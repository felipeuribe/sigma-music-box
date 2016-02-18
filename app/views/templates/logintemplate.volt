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
                        </div>   
                    </div>    

                    {% block content %}

                    {% endblock %}
   
                </div>
            </div>
        </div>
    </body>
</html>

