{% extends "templates/logintemplate.volt" %}
{% block content %}
    <div  class="row">
        <div class="col-md-12">
            <h1>Ingresar Un Nuevo Usuario</h1>
            
        </div>
    </div>
    <div  class="row">
        <div class="col-md-12">
            <br>
            {{flashSession.output()}}
        </div>
    </div>    
    <div  class="row">
        <div class="col-md-offset-3 col-md-6">
            <form action="{{url('Account/signup')}}" method="post" >
                
                <div class="form-group">
                  <label>Nombre del Usuario</label>
                  <input type="text" name="name" class="form-control" placeholder="Nombre del Usuario" >
                </div>
                <div class="form-group">
                  <label>Apellido del Usuario</label>
                  <input type="text" name="lastName" class="form-control"  placeholder="Apellido del Usuario" >
                </div>
                <div class="form-group">
                  <label>Correo Electrónico del Usuario</label>
                  <input type="text" name="email" class="form-control" placeholder="Correo@gmail.com" >
                </div>
                <div class="form-group">
                  <label>Crea Una Contraseña</label>
                  <input type="password" name="password" class="form-control" placeholder="Password" >
                </div>
                <div class="form-group">
                  <label>Confirma su Contraseña</label>
                  <input type="password" name="password2" class="form-control" placeholder="Password" >
                </div>
                <div class="form-group">
                  <label>Elija su Nombre de Usuario en el Sistema</label>
                  <input type="text" name="username" class="form-control" placeholder="" >
                </div>
                
                <a href="{{url('account/login')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i></button>                          
            
            </form>  
        </div>
    </div>
{% endblock  %}

