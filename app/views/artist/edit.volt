{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h1>Actualizar El Artista.</h1>
            <hr>
        </div>
    </div>   
    
    <div  class="row"> 
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
            
            {{flashSession.output()}}
        </div>        
        <div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">                
            <P>
                <h4>Seguro Desea Actualizar La Imagen Del Artista <span class="label label-default">{{artist.name}}</span></h4>
            </P>
            <form action="{{url('artist/edit')}}/{{artist.idArtist}}" method="post">
                <label>Nuevo Nombre del Artista</label>
                <input type="text" name="name" class="form-control" id="name" value="{{artist.name}}" >
                <br>    
                <label>Nuevo Pais del Artista</label>
                <input type="text" name="country" class="form-control" id="country" value="{{artist.country}}" >
                <br>
                 <div class="form-group">
                    <label for="name">Seleccione Los Generos Del Artista</label>
                    <select multiple name="genders[]" class="form-control">
                        {% for gender in genders %}
                            <option value="{{gender.idGender}}"
                                    {% for gxa in gxas %}
                                        {% if gender.idGender == gxa.idGender%}selected{% endif %}
                                    {% endfor %}>
                                        {{gender.name}}
                            </option>
                        {% endfor %}
                    </select>
                </div>
                
                
                <a href="{{url('artist/list')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"> </i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check" {{url('artist/edit')}}></i>
                    
            </form>
        </div>
    </div>
{% endblock%}
                
           


