@extends('POS.Sale.menuLayout')


@section('content')

    Entrez votre numéro d'employé.


    Entrez votre mot de passe.


    Entrez le numéro de la table()
    (Autre action s'affiche)
    -Voir plan
    -Voir list
    -Punch IN/OUT
    <p><a href="{{ @URL::to('/menu') }}">Menu</a></p>

@stop

@section('myjsfile')
    <script type="text/javascript">
        window.loading_screen = window.pleaseWait({
            logo: "{{ URL::to('Framework/please-wait/posio.png')  }}",
            backgroundColor: '#222',
            loadingHtml: "<div class='spinner'>" +
            "<a href='{{ @URL::to('/menu') }}'><button type='button' class='btn btn-primary'>Lancer</button></a>" +
            "<a href='{{ @URL::to('/') }}'><button type='button' class='btn btn-danger'>Quitter</button></a></div>"
        });
    </script>
@stop