{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Listado de Géneros.</h1>
            <hr>
        </div>
    </div>    
    
    <div class="row">     
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('gender/new')}}" class="btn btn-success">
                <i class="fa fa-plus"></i>
            </a>
        </div>   
    </div>        
        
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <br>
            {{flashSession.output()}}
        </div>
    </div>    
        
    <div class="row">            
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="table-responsive"> 
                <table class="table"> 
                    <thead> 
                        <tr>                                  
                            <th>ID </th> 
                            <th>Nombre</th> 
                            <th>Fechas</th>
                            <th>Imagen Del Genero</th>
                            <th></th>
                        </tr> 
                    </thead> 
                    <tbody>
                {% for gender in gender %}
                        <tr> 
                            <td>{{gender.idGender}}</td> 
                            <td><strong> {{gender.name}}</strong></td> 
                            <td>
                                Creado el: {{date('d-M-Y - H:i:s' , gender.createdon)}} 
                                <br> 
                                Actualizado el: {{date('d-M-Y - H:i:s' , gender.updatedon)}}
                            </td> 
                            <td>
                                <img class="album-cover-list" src="{{url('')}}assets/genders/images/{{gender.idGender}}/{{gender.idGender}}.jpg">
                            </td> 
                            <td>
                                <a href="{{url('gender/changeimage')}}/{{gender.idGender}}" class="btn btn-xs btn-success">
                                    <span class="fa fa-picture-o"></span>
                                </a>
                                <a href="{{url('gender/edit')}}/{{gender.idGender}}" class="btn btn-xs btn-primary">
                                    <span class="fa fa-pencil"></span>
                                </a> 
                                <a href="{{url('gender/confirm')}}/{{gender.idGender}}" class="btn btn-xs btn-danger">
                                    <span class="fa fa-times"></span>
                                </a>
                            </td>
                        </tr>
                {% endfor %}
                    </tbody> 
                </table> 
            </div>
        </div>
    </div>
{% endblock %}
                     