<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddWebSite">    
        @csrf
        <input type="hidden" id="websiteId" name="websiteId">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nuevo WebSite</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="for-group">
                        <label for="title">Titulo</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Titulo de la web">
                    </div>
                    <div class="input-group mt-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-code"></i></span>
                        </div>
                        <input type="text" class="form-control" id="slug" disabled name="slug">
                    </div>
                    <div class="for-group mt-2">
                        <label class="col-form-label" for="description"><i class="fas fa-check"></i> Descripcion</label>
                        <textarea class="form-control" rows="3" id="description" name="description" placeholder="Breve descripcion"></textarea>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input class="form-control" name="logo" type="file" id="logo">
                            </div>        
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group" style="width: 80px;">
                                <img id="plogo" src="/images/movie-default.JPG" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="name">Background</label>
                                <input class="form-control" name="background" type="file" id="background">
                            </div>        
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <img id="pbackground" src="/images/movie-default.JPG" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="color1">Color 1</label>
                                <input type="text" class="form-control" id="color1" name="color1">
                            </div>        
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="color2">Color 2</label>
                                <input type="text" class="form-control" id="color2" name="color2">
                            </div>
                        </div>                    
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="color3">Color 3</label>
                                <input type="text" class="form-control" id="color3" name="color3">
                            </div>        
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="color4">Color 4</label>
                                <input type="text" class="form-control" id="color4" name="color4">
                            </div>
                        </div>
                    </div>            
                </div>
                <div class="modal-footer">
                    <button id="addWebSite" type="button" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>