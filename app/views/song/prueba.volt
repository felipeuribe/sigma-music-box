{% extends "templates/template.volt" %}
{% block content %}
    <div  class="row">
        <div class="col-md-12">
            <h1>Prueba</h1>
            <hr>
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
            <form action="{{url('song/prueba')}}" method="post">                           
                
                
                <div class="form-group">
                    <label>Numero 1</label>
                    <input type="text" name="num1" class="form-control" id="num1" placeholder="00:00" >
                </div>                 
                
                
                
                                  
                 
                <a href="{{url('song/substractTimes')}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-check"></i></button> 
                
            </form>  
        </div>
    </div>
{% endblock  %}

