{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Actualizar La Imagen Del Genero.</h1>
            <hr>
        </div>
    </div>   
    
    <div  class="row"> 
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            
            {{flashSession.output()}}
        </div>        
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">                
            <P>
               <h4>Seguro Desea Actualizar La Imagen Del Genero <span class="label label-default">{{gender.name}}</span></h4>
            </P>
            <form action="{{url('gender/changeimage')}}/{{gender.idGender}}" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                  <label for="gender-cover">Selecciona la Nueva Imagen Del Genero</label>
                  <input type="file" name="gender-cover" id="gender-cover" >
                  <p class="help-block">Jpg.</p>
                </div>
                
                
                <a href="{{url('gender/list')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"> </i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check" {{url('gender/changeimage')}}></i>
                    
            </form>
        </div>
    </div>
{% endblock%}
                
           


