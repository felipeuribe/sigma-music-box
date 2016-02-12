{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Listado de Artistas.</h1>
            <hr>
        </div>
    </div>  
    <div class="row">     
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
            <a href="{{url('artist/new')}}" class="btn btn-success">
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
                            <th>Pais</th>
                            <th>Fecha</th>
                            <th>Género</th>
                            <th>Imagen Del Artista</th>
                            <th> </th>
                        </tr> 
                    </thead> 
                    <tbody>
                {% for artist in artists %}
                        <tr> 
                            <td>{{artist.idArtist}}</td> 
                            <td><strong> {{artist.name}}</strong></td>
                            <td> {{artist.country}}</td>
                            <td>
                                Creado el: {{date('d-M-Y - h:i:s A' , artist.createdon)}} 
                                <br> 
                                Actualizado el: {{date('d-M-Y - h:i:s A' , artist.updatedon)}}
                            </td>
                            <td>
                                {% for gxa in gxas %}
                                    {% if gxa.idArtist == artist.idArtist %}
                                        {% for gender in genders %}
                                            {% if gender.idGender == gxa.idGender %}
                                                {{gender.name}} <br>
                                            {% endif %}    
                                        {% endfor %}
                                    {% endif %}    
                                {% endfor %} 
                            </td>
                            <td>
                                <img class="album-cover-list" src="{{url('')}}assets/artists/images/{{artist.idArtist}}/{{artist.idArtist}}.jpg">
                            </td>
                            <td>
                                <a href="{{url('artist/changeimage')}}/{{artist.idArtist}}" class="btn btn-xs btn-success">
                                    <span class="fa fa-picture-o"></span>
                                </a>
                                <a href="{{url('artist/edit')}}/{{artist.idArtist}}" class="btn btn-xs btn-primary">
                                    <span class="fa fa-pencil"></span>
                                </a> 
                                <a href="{{url('artist/confirm')}}/{{artist.idArtist}}" class="btn btn-xs btn-danger">
                                    <span class="fa fa-minus-square"></span>
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
                     