<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <link href='https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css'>
        {{ stylesheet_link('library/font-awesome/css/font-awesome.min.css') }}
        {{ stylesheet_link('library/bootstrap/css/bootstrap.min.css') }}
        {{ stylesheet_link('library/bootstrap/css/bootstrap-theme.min.css') }}
        {{ javascript_include('library/jquery/jquery-1.12.0.min.js') }}
        {{ javascript_include('library/bootstrap/js/bootstrap.min.js') }}
        {{ stylesheet_link('css/estilo.css') }}
        <title>
            Sigma Music Box
        </title>
        {% block header %}{% endblock %}
    </head>
    <body>       
        <div class="container-fluid">
            <div class="row fill">
                <div class="col-md-offset-2 col-md-8 background-black fill">
                    <div class="row header">
                        <div class="col-md-12">
                            <div class="col-md-6 app-title">
                                <a href="{{url('')}}">
                                    <i class="fa fa-play-circle"></i> Sigma Music Box
                                </a>
                            </div>    
                            <div class="col-md-6 text-right">                    
                                <ul class="nav nav-pills float-left" role="tablist"> 
                                    <li role="presentation" class="dropdown"> 
                                        <a id="drop4" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
                                            <span class="caret"></span> 
                                        </a> 
                                        <ul id="menu1" class="dropdown-menu" aria-labelledby="drop4"> 
                                            <li><a href="#">Cerrar Sesión</a></li>
                                        </ul> 
                                    </li> 
                                </ul>
                            </div>
                        </div>   
                    </div>    

                    {% block content %}

                    {% endblock %}

                    <div class="row ">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="row  footer-menu">
                                <div class="col-md-3 btn btn-primaria"><a href="{{url('gender/index')}}"> Generos </a></div>
                                <div class="col-md-2 btn btn-primaria"><a href="{{url('artist/index')}}"> Artistas </a></div>
                                <div class="col-md-2 btn btn-primaria"><a href="{{url('album/index')}}"> Albumes </a></div>
                                <div class="col-md-2 btn btn-primaria"><a href="{{url('song/index')}}"> Canciones </a></div>
                                <div class="col-md-3 btn btn-primaria"><a href="{{url('tools/index')}}"> configuración </a></div>
                            </div> 
                        </div>   
                    </div>    
                </div>
            </div>
        </div>
    </body>
</html>

