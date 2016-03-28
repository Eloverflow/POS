@extends('POS.Command.mainLayout')

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
    </div>

@stop