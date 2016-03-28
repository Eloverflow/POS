@extends('POS.Sale.mainLayout')

@section('content')

<div>
    <table id="keyboard">
        <tbody>
        <tr>
            <td>Del</td>
            <td>/</td>
            <td>*</td>
            <td>-</td>
        </tr>

        <tr>
            <td>7</td>
            <td>8</td>
            <td>9</td>
            <td rowspan="2">+</td>
        </tr>

        <tr>
            <td>4</td>
            <td>5</td>
            <td>6</td>
        </tr>

        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td rowspan="2">Ent</td>
        </tr>

        <tr>
            <td colspan="2">0</td>
            <td>.</td>
        </tr>
        </tbody>
    </table>

    <table id="keyboard">
        <tbody>
            <tr>
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>9</td>
                <td>0</td>
            </tr>

            <tr>
                <td>Q</td>
                <td>W</td>
                <td>E</td>
                <td>R</td>
                <td>T</td>
                <td>Y</td>
                <td>U</td>
                <td>I</td>
                <td>O</td>
                <td>P</td>
            </tr>

            <tr>
                <td>A</td>
                <td>S</td>
                <td>D</td>
                <td>F</td>
                <td>G</td>
                <td>H</td>
                <td>J</td>
                <td>K</td>
                <td>L</td>
                <td rowspan="2">Ent</td>
            </tr>

            <tr>
                <td>Z</td>
                <td>X</td>
                <td>C</td>
                <td>V</td>
                <td>B</td>
                <td>N</td>
                <td>M</td>
                <td>,</td>
                <td>.</td>
            </tr>

            <tr>
                <td>=</td>
                <td>-</td>
                <td colspan="5">Space</td>
                <td>+</td>
                <td>&</td>
                <td>Exit</td>
            </tr>
        </tbody>
    </table>
</div>
@stop