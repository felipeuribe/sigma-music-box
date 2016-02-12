{% extends "templates/template.volt" %}
{% block content %}
    <div class="row">
        <hr>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">            
            <a href="{{url('gender/list')}}" >
                <button type="button" class="btn btn-primary btn-lg album-cover">
                    Generos 
                </button>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">            
            <a href="{{url('artist/list')}}" >
                <button type="button" class="btn btn-primary btn-lg album-cover">
                    Artistas 
                </button>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">            
            <a href="{{url('album/list')}}" >
                <button type="button" class="btn btn-primary btn-lg album-cover">
                    Álbumes 
                </button>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 text-center">            
            <a href="{{url('song/list')}}" >
                <button type="button" class="btn btn-primary btn-lg album-cover">
                    Canciones 
                </button>
            </a>
        </div>       
    </div> 
        <hr>
{% endblock %}
