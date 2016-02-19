{{ stylesheet_link('css/errorestilo.css') }}
{% block content %}  
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Página no encontrada</title>
</head>
<body>
    <div class="error-page-wrap">
        <article class="error-page gradient">
                <hgroup>
                    <h1>404</h1><br>
                        <h2>¡Uy ! Página no encontrada</h2>
                </hgroup>
                <a href="{{url('account/login')}}" title="Back to site" class="error-back">Inicio</a>
        </article>
    </div>
</body>
</html>
{% endblock %}