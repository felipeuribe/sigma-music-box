{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Actualizar Género.</h1>
            <hr>
        </div>
    </div>    
    <div  class="row">            
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">                
            <P>
                Sí actualiza este género, ya no podrá recuperar los datos
            </P>
            <form action="{{url('gender/edit')}}/{{gender.idGender}}" method="post" enctype="multipart/form-data">
                <label for="name">Nuevo Genero</label>
                <input type="text" name="name" class="form-control" id="name" value="{{gender.name}}" >
                <br>
                <a href="{{url('gender/list')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"> </i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check" {{url('gender/list')}}></i>
                
                </button>
            </form>
        </div>
    </div>
{% endblock%}
                
           


