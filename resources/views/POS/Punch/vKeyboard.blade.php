@extends('POS.Punch.mainLayout')

@section('content')

<div>
    <table id="keyboard">
        <tbody>
        <tr>
            <td><button class="button">Del</button></td>
            <td><button class="button">/</button></td>
            <td><button class="button">*</button></td>
            <td><button class="button">-</button></td>
        </tr>

        <tr>
            <td><button class="button">7</button></td>
            <td><button class="button">8</button></td>
            <td><button class="button">9</button></td>
            <td rowspan="2"><button class="button">+</button></td>
        </tr>

        <tr>
            <td><button class="button">4</button></td>
            <td><button class="button">5</button></td>
            <td><button class="button">6</button></td>
        </tr>

        <tr>
            <td><button class="button">1</button></td>
            <td><button class="button">2</button></td>
            <td><button class="button">3</button></td>
            <td rowspan="2"><button class="button">Ent</button></td>
        </tr>

        <tr>
            <td colspan="2"><button class="button">0</button></td>
            <td><button class="button">.</button></td>
        </tr>
        </tbody>
    </table>

    <table id="keyboard">
        <tbody>
            <tr>
                <td><button class="button">1</button></td>
                <td><button class="button">2</button></td>
                <td><button class="button">3</button></td>
                <td><button class="button">4</button></td>
                <td><button class="button">5</button></td>
                <td><button class="button">6</button></td>
                <td><button class="button">7</button></td>
                <td><button class="button">8</button></td>
                <td><button class="button">9</button></td>
                <td><button class="button">0</button></td>
            </tr>

            <tr>
                <td><button class="button">Q</button></td>
                <td><button class="button">W</button></td>
                <td><button class="button">E</button></td>
                <td><button class="button">R</button></td>
                <td><button class="button">T</button></td>
                <td><button class="button">Y</button></td>
                <td><button class="button">U</button></td>
                <td><button class="button">I</button></td>
                <td><button class="button">O</button></td>
                <td><button class="button">P</button></td>
            </tr>

            <tr>
                <td><button class="button">A</button></td>
                <td><button class="button">S</button></td>
                <td><button class="button">D</button></td>
                <td><button class="button">F</button></td>
                <td><button class="button">G</button></td>
                <td><button class="button">H</button></td>
                <td><button class="button">J</button></td>
                <td><button class="button">K</button></td>
                <td><button class="button">L</button></td>
                <td rowspan="2"><button class="button">Ent</button></td>
            </tr>

            <tr>
                <td><button class="button">Z</button></td>
                <td><button class="button">X</button></td>
                <td><button class="button">C</button></td>
                <td><button class="button">V</button></td>
                <td><button class="button">B</button></td>
                <td><button class="button">N</button></td>
                <td><button class="button">M</button></td>
                <td><button class="button">,</button></td>
                <td><button class="button">.</button></td>
            </tr>

            <tr>
                <td><button class="button">=</button></td>
                <td><button class="button">-</button></td>
                <td colspan="5"><button class="button">Space</button></td>
                <td><button class="button">+</button></td>
                <td><button class="button">&</button></td>
                <td><button class="button">Exit</button></td>
            </tr>
        </tbody>
    </table>
</div>
@stop