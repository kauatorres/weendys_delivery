 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Adicionar produto</h1>
             </div><!-- /.col -->
         </div><!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
     <div class="container-fluid">
         <?php if (!empty($msg)) {  ?>
             <div class="callout callout-<?= $alert; ?>">
                 <h5><?= $textHeader; ?></h5>
                 <p><?= $msg; ?></p>
             </div>
         <?php } ?>
         <div class="row">
             <div class="col-md-8">
                 <div class="card card-primary">


                     <form method="POST" action="<?= BASE_URL . "produtos/action_add" ?>" id="addItem" class="addItem" enctype="multipart/form-data" autocomplete="off">
                         <div class=" card-body">
                             <div class="form-group">
                                 <label for="">Nome do produto</label>
                                 <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Insira o nome do produto" required>
                             </div>
                             <div class="form-group">
                                 <div class="row">
                                     <div class="col-sm-6">

                                         <div class="form-group">
                                             <label>Selecione a categoria</label>
                                             <select class="custom-select" name="category" required>
                                                 <option value="">Selecione uma categoria</option>
                                                 <?php foreach ($listCategories as $category) { ?>
                                                     <option value="<?= $category['id_categoria']; ?>"><?= $category['nome_categoria']; ?></option>
                                                 <?php }   ?>
                                             </select>
                                         </div>
                                     </div>
                                     <div class="col-sm-6">
                                         <div class="form-group">
                                             <label>Disponibilidade</label>
                                             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                                 <input type="checkbox" class="custom-control-input" id="disponibilidade" name="disponibility" value="1" checked>
                                                 <label class="custom-control-label" for="disponibilidade">Disponível</label>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>


                             <div class="form-group">
                                 <div class="row">


                                     <div class="col-sm-8">
                                         <div class="form-group">
                                             <label>Tamanho</label>
                                             <input type="text" class="form-control" name="product_size[]" id="tamanho" placeholder="Ex: Médio" required>
                                         </div>
                                     </div>
                                     <div class="col-sm-4">
                                         <div class="form-group">
                                             <label>Preço</label>
                                             <div class="input-group">
                                                 <div class="input-group-prepend">
                                                     <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                                                 </div>
                                                 <input type="text" name="product_price[]" id="preco" class="money form-control" placeholder="0" inputmode="numeric">

                                                 <div class="input-group-append">
                                                     <button type="button" id="add" onclick="adicionarCampo()" class="btn btn-success input-group-text"><i class="fa-solid fa-plus"></i></button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>



                                 </div>
                                 <div id="plusplus"></div>
                             </div>

                             <div class="form-group">
                                 <label for="">Descrição produto</label>
                                 <textarea class="form-control" name="description" rows="5" placeholder="Descrição"></textarea>
                             </div>

                             <div class="form-group">
                                 <label for="">Foto do produto</label>
                                 <div class="input-group">
                                     <div class="custom-file">
                                         <input type="file" class="custom-file-input" accept="image/png, image/jpeg" id="product_photo" name="product_photo">
                                         <label class="custom-file-label" for="">Escolha um arquivo</label>
                                     </div>
                                 </div>
                             </div>



                         </div>
                         <!-- /.card-body -->
                         <div class="card-footer">
                             <button type="submit" class="btn btn-success float-right">Adicionar produto</button>
                         </div>
                     </form>
                 </div>
             </div>





         </div>


     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->