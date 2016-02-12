{% extends "templates/template.volt" %}

{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Eliminar Género.</h1>
            <hr>
        </div>
    </div> 
    
    <div  class="row">            
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">                
            <P>
                Sí elimina este Género, Ya no podrá recuperar los datos de los Artistas Relacionados con este Genero.
                <br>
                ¿Esta seguro que desea eliminar este género?
            </P>
            <a href="{{url('gender/list')}}" class="btn btn-sm btn-default ">No</a>
            <a href="{{url('gender/delete')}}/{{idGender}}" class="btn btn-sm btn-danger">Si</a>
        </div>
    </div>
{% endblock%}
