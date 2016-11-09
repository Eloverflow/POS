
var dataCurrentTable;
var dataPlan;

/*Function to get the plan from database then display it*/
function getPlan() {
    $url = 'http://pos.mirageflow.com/api/table-plan/1';

    /*What to do with the plan received*/
    var $callbackFunction = function (response) {

        var floor = 0;

        if (typeof dataPlan != "undefined" && dataPlan != null)
            floor = dataPlan.currentFloor;

        dataPlan = response;

        dataPlan.currentFloor = floor;

        if (typeof dataCurrentTable == 'undefined' || dataCurrentTable == null)
            dataCurrentTable = dataPlan.table[0];

        generatePlanPreview();


    };
    getReq.send($url, null, $callbackFunction);

    $.ajax({ type: "GET",
        url: $url,
        async: false,
        success : $callbackFunction(text)
    });

}
getPlan();


function generatePlanPreview() {

    var planModal = $('#planModal');
    var canvas = $('#planCanvas');
    canvas.remove();
    planModal.find('.panzoom').append('<canvas style="margin: 0;" id="planCanvas" width="0" height="0" />');
    canvas = $('#planCanvas');

    /*50 is the menu header*/
    var canvasWidth = window.innerWidth;
    var canvasHeight = window.innerHeight - 51;

    planModal.attr('width', canvasWidth);
    planModal.attr('height', canvasHeight);


    canvas.attr('width', canvasWidth);
    canvas.attr('height', canvasHeight);

    var elem = document.getElementById('planCanvas'),
        context = elem.getContext('2d'),
        elements = [];

    context.clearRect(0, 0, canvas.width, canvas.height);
    elements = [];

    // Add event listener for `click` events.
    elem.addEventListener('click', function (event) {

        var offset = this.getClientRects()[0];

        var x = (event.clientX - offset.left),
            y = (event.clientY - offset.top);

        /*Adjust with the zoom*/
        x /= $scope.totalIncrement;
        y /= $scope.totalIncrement;


        elements.forEach(function (element) {
            var top = element.top,
                left = element.left,
                height = element.height,
                width = element.width,
                angle = element.angle;

            /*Rotation begin*/
            var originX = left + width / 2,
                originY = top + height / 2;
            // translate mouse point values to origin
            var dx = x - originX, dy = y - originY;
            // distance between the point and the center of the rectangle
            var h1 = Math.sqrt(dx * dx + dy * dy);
            var currA = Math.atan2(dy, dx);
            // Angle of point rotated around origin of rectangle in opposition
            var newA = currA - angle; //45 rad here
            // New position of mouse point when rotated
            var x2 = Math.cos(newA) * h1;
            var y2 = Math.sin(newA) * h1;
            /*Rotation end*/

            // Check relative to center of rectangle after rotation
            if (x2 > -0.5 * width && x2 < 0.5 * width && y2 > -0.5 * height && y2 < 0.5 * height) {
                console.log('Clicked table : ' + element.name);

                var selectedTable = $filter("filter")(dataPlan.table, {id: element.id});

                $scope.changeTable(selectedTable[0]);
                $scope.showPlanModal = false;
            }
        });

    }, false);

    planBiggerX = 0;
    planBiggerY = 0;
    planXProportion = 0;
    planYProportion = 0;
    planWallPoints = dataPlan.wallPoints;
    var onePoint = planWallPoints.split(",");
    if (onePoint != "") {

        for (var m = 0; m < onePoint.length; m++) {
            var coordonate = onePoint[m].split(":");

            var x1 = parseInt(coordonate[0]);
            var y1 = parseInt(coordonate[1]);

            if (x1 > planBiggerX) {
                planBiggerX = x1;
            }

            if (y1 > planBiggerY) {
                planBiggerY = y1;
            }
        }

        // 99 for small margin
        planXProportion = 0.99 / (planBiggerX / canvas.attr('width'));
        planYProportion = 0.99 / (planBiggerY / canvas.attr('height'));
        /*xProportion =  1;
         yProportion = 1;*/

        context.beginPath();
        context.strokeStyle = "#222";
        context.lineWidth = 8;
        context.lineJoin = 'round';
        for (m = 0; m < onePoint.length; m++) {
            coordonate = onePoint[m].split(":");

            x1 = parseInt(coordonate[0]);
            y1 = parseInt(coordonate[1]);

            if (x1 > planTableWidth / 2) {
                x1 -= planTableWidth / 2;
            }
            x1 *= planXProportion;
            y1 *= planYProportion;


            if (m == 0)
                context.moveTo(x1, y1);
            else
                context.lineTo(x1, y1);
        }
        context.closePath();
        context.fillStyle = '#444';
        context.fill();
        context.stroke();
        context.clip();

    }

    var separationElements = [];
    for (var i = 0; i < dataPlan.separation.length; i++) {

        if (dataPlan.separation[i].noFloor == dataPlan.currentFloor) {
            /*0.6 is a base reducer*/
            var width = dataPlan.separation[i].w * planXProportion;
            var height = dataPlan.separation[i].h * planYProportion;
            var angle = parseFloat(dataPlan.separation[i].angle.substring(0, 4));
            var color = '#222';


            // Add element.
            separationElements.push({
                id: dataPlan.separation[i].id,
                angle: angle,
                colour: color,
                width: width,
                height: height,
                top: parseInt(dataPlan.separation[i].yPos) * planYProportion,
                left: parseInt(dataPlan.separation[i].xPos) * planXProportion
            });
        }
    }


    /*For each table inside the plan we push an element inside an array of canvas object*/
    /*We can evaluate table variable here*/
    for (var i = 0; i < dataPlan.table.length; i++) {

        if (dataPlan.table[i].noFloor == dataPlan.currentFloor) {
            /*0.6 is a base reducer*/
            var width = planTableWidth * planXProportion;
            var height = planTableHeight * planYProportion;
            var angle = parseFloat(dataPlan.table[i].angle.substring(0, 4));
            var color = '#00a5ff';

            if (dataPlan.table[i].status == 2)
                color = '#EC0033'
            if (dataPlan.table[i].status == 3)
                color = '#8ad919'

            if (dataPlan.table[i].type == "plc")
                width = height;

            // Add element.
            elements.push({
                id: dataPlan.table[i].id,
                name: dataPlan.table[i].tblNumber,
                type: dataPlan.table[i].type,
                status: dataPlan.table[i].status,
                angle: angle, /*
                 angle : 90,*/
                colour: color,
                width: width,
                height: height,
                top: parseInt(dataPlan.table[i].yPos) * planYProportion + height / 2,
                left: parseInt(dataPlan.table[i].xPos) * planXProportion
            });
        }
    }


    // Render elements.
    elements.forEach(function (element) {
        context.save();
        context.beginPath();
        context.fillStyle = element.colour;

        /*This represent the onClick listener detection*/
        //context.strokeStyle="red";
        //context.strokeRect(element.left,  element.top, width, height);
        /*End of - This represent the onClick listener detection*/

        /*This next part is to be able to rotate the rectangle using the corner only when needed*/
        var angle = Math.abs(element.angle);
        if (angle >= 3.12) {
            angle -= 3.12;
        }
        if (angle >= 1.5) {
            var curHeight = element.height;
            if (angle >= 2.15) {
                curHeight /= 2;
            }
            context.translate(element.left + element.height / 2, element.top + curHeight);
        } else {
            context.translate(element.left + element.width / 2, element.top + element.height / 2);
        }

        context.rotate(element.angle);
        context.fillRect(-element.width / 2, -element.height / 2, element.width, element.height);

        /*A little suplement*/
        paint_centered(document.getElementById('planCanvas'), -element.width / 2, -element.height / 2, element.width, element.height, element.name, element.angle);
        context.restore();
    });

    // Render separation elements.
    separationElements.forEach(function (element) {
        context.save();
        context.beginPath();
        context.fillStyle = element.colour;

        /*This next part is to be able to rotate the rectangle using the corner only when needed*/
        /*Not as efficient as needed*/
        var angle = Math.abs(element.angle);
        if (angle >= 3.12) {
            angle -= 3.12;
        }
        if (angle >= 1.5) {
            var curHeight = element.height;
            if (angle >= 2.15) {
                curHeight /= 2;
            }
            context.translate(element.left + element.height / 2, element.top + curHeight);
        } else {
            context.translate(element.left + element.width / 2, element.top + element.height / 2);
        }

        context.rotate(element.angle);
        context.fillRect(-element.width / 2, -element.height / 2, element.width, element.height);

        context.restore();
    });

}





/*This make magic for every table inside the plan canvas*/
/**
 * @param canvas : The canvas object where to draw .
 *                 This object is usually obtained by doing:
 *                 canvas = document.getElementById('canvasId');
 * @param x     :  The x position of the rectangle.
 * @param y     :  The y position of the rectangle.
 * @param w     :  The width of the rectangle.
 * @param h     :  The height of the rectangle.
 * @param text  :  The text we are going to centralize
 * @param angle  :  The angle of the rectangle,to nullify with text number.
 */
var paint_centered = function (canvas, x, y, w, h, text, angle) {
    // The painting properties
    // Normally I would write this as an input parameter
    var Paint = {
        RECTANGLE_STROKE_STYLE: '#222',
        RECTANGLE_LINE_WIDTH: 3,
        VALUE_FONT: '28px Arial',
        VALUE_FILL_STYLE: 'white'
    };

    // Obtains the context 2d of the canvas
    // It may return null
    var ctx2d = canvas.getContext('2d');

    if (ctx2d) {
        // draw rectangular
        ctx2d.strokeStyle = Paint.RECTANGLE_STROKE_STYLE;
        ctx2d.fillStyle = "#222";
        ctx2d.lineWidth = Paint.RECTANGLE_LINE_WIDTH;
        ctx2d.strokeRect(x, y, w, h);
        ctx2d.lineWidth = Paint.RECTANGLE_LINE_WIDTH + 2;

        var width,
            height;

        /*If this is square, which also mean it is a plc and not a tbl*/
        /*This impact the number of seat*/
        if (w == h) {
            width = w / 2;
            height = h / 2;

            /*Seats border background*/
            /*Bottom*/
            ctx2d.fillRect(x + w / 2 / 2, y + h * 1.1, width, height);

            /*Top*/
            ctx2d.fillRect(x + w / 2 / 2, y * 2.2, width, height);

            /*Left*/
            ctx2d.fillRect(x - (h / 2) * 1.2, -width / 2, height, width);

            /*Right*/
            ctx2d.fillRect(x + w / 2 + width * 1.2, -width / 2, height, width);
            /*End Seats*/


            ctx2d.fillStyle = "#333";
            /*Seats*/
            /*Bottom*/
            ctx2d.fillRect(x + w / 2 / 2 + 2, y + h * 1.1 + 2, width - 4, height - 4);

            /*Top*/
            ctx2d.fillRect(x + w / 2 / 2 + 2, y * 2.2 + 2, width - 4, height - 4);

            /*Left*/
            ctx2d.fillRect(x - (h / 2) * 1.2 + 2, -width / 2 + 2, height - 4, width - 4);

            /*Right*/
            ctx2d.fillRect(x + w / 2 + width * 1.2 + 2, -width / 2 + 2, height - 4, width - 4);
            /*End Seats*/
        }
        else {
            width = w / 4;
            height = h / 2;

            /*Seats border background*/
            /*Bottom*/
            ctx2d.fillRect(x + w / 2 + width, y + h * 1.1, width, height);
            ctx2d.fillRect(x + w / 2 / 2 + width / 2, y + h * 1.1, width, height);
            ctx2d.fillRect(x + w / 2 / 2 - width, y + h * 1.1, width, height);

            /*Top*/
            ctx2d.fillRect(x + w / 2 + width, y * 2.2, width, height);
            ctx2d.fillRect(x + w / 2 / 2 + width / 2, y * 2.2, width, height);
            ctx2d.fillRect(x + w / 2 / 2 - width, y * 2.2, width, height);

            /*Left*/
            ctx2d.fillRect(x - (h / 2) * 1.2, -width / 2, height, width);

            /*Right*/
            ctx2d.fillRect(x + w / 2 + width * 2.2, -width / 2, height, width);
            /*End Seats*/


            ctx2d.fillStyle = "#333";
            /*Seats*/
            /*Bottom*/
            ctx2d.fillRect(x + w / 2 + width + 2, y + h * 1.1 + 2, width - 4, height - 4);
            ctx2d.fillRect(x + w / 2 / 2 + width / 2 + 2, y + h * 1.1 + 2, width - 4, height - 4);
            ctx2d.fillRect(x + w / 2 / 2 - width + 2, y + h * 1.1 + 2, width - 4, height - 4);

            /*Top*/
            ctx2d.fillRect(x + w / 2 + width + 2, y * 2.2 + 2, width - 4, height - 4);
            ctx2d.fillRect(x + w / 2 / 2 + width / 2 + 2, y * 2.2 + 2, width - 4, height - 4);
            ctx2d.fillRect(x + w / 2 / 2 - width + 2, y * 2.2 + 2, width - 4, height - 4);

            /*Left*/
            ctx2d.fillRect(x - (h / 2) * 1.2 + 2, -width / 2 + 2, height - 4, width - 4);

            /*Right*/
            ctx2d.fillRect(x + w / 2 + width * 2.2 + 2, -width / 2 + 2, height - 4, width - 4);
            /*End Seats*/
        }


        // draw text (this.val)
        ctx2d.textBaseline = "middle";
        ctx2d.font = Paint.VALUE_FONT;
        ctx2d.fillStyle = Paint.VALUE_FILL_STYLE;
        // ctx2d.measureText(text).width/2
        // returns the text width (given the supplied font) / 2
        var textX = x + w / 2 - ctx2d.measureText(text).width / 2;
        var textY = y + h / 2;
        ctx2d.rotate(-angle);
        ctx2d.fillText(text, textX, textY);
    } else {
        // Do something meaningful
    }
}