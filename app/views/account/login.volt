{% extends "templates/logintemplate.volt" %}
{% block content %}
        
<div class="loginbox mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
        <div class="panel panel-info" >
            <div class="panel-heading">
                <div class="panel-title">Inicio De Sesión</div>               
            </div>  

            <div class="panel-body panel-body-bor" >
                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                <div  class="row">
                    <div class="col-md-12">
                        <br>
                        {{flashSession.output()}}
                    </div>
                </div> 
                <form action="{{url('Account/login')}}" method="post" >                                 
                    
                    <div class="input-group input-group-login">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name="userName" value="" placeholder="Nombre De Usuario">                                        
                    </div>                                
                    <div class="input-group input-group-login">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" name="password" placeholder="Contraseña">
                    </div>
                    
                    <div class="form-group input-group-login">
                        <div class="col-sm-12 controls">
                          
                           <button type="submit" class="btn btn-success">Iniciar Sesión</button>
                          <a  href="{{url('Account/signup')}}" class="btn btn-primary">Crear Una Nueva Cuenta </a>
                        </div>
                    </div>
                </form> 
            </div>                     
        </div>  
    </div>
{% endblock  %}

