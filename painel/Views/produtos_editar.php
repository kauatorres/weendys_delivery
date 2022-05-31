 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Editar produto</h1>
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
                     <?php foreach ($getInfoProduct as $product) {  ?>

                         <form method="POST" action="<?= BASE_URL . "produtos/product_action_edit/" . $product['idProduto'] ?>" id="addItem" class="addItem" enctype="multipart/form-data" autocomplete="off">
                             <div class=" card-body">
                                 <div class="form-group">
                                     <label for="">Nome do produto</label>
                                     <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Insira o nome do produto" value="<?= $product['produto']; ?>" required>
                                 </div>
                                 <div class="form-group">
                                     <div class="row">
                                         <div class="col-sm-6">

                                             <div class="form-group">
                                                 <label>Editar categoria</label>
                                                 <select class="custom-select" name="category" required>
                                                     <option value="<?= $product['id_categoria']; ?>"><?= $product['nome_categoria']; ?></option>
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
                                                     <input type="checkbox" class="custom-control-input" id="disponibilidade" name="disponibility" value="1" <?= ($product['statusDisponibilidade'] == 1) ? 'checked' : ''  ?>>
                                                     <label class="custom-control-label" for="disponibilidade"><?= ($product['statusDisponibilidade'] == 1) ? 'Disponível' : 'Indisponível'  ?></label>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>


                                 <div class="form-group">
                                     <div class="d-grid gap-2">
                                         <button type="button" id="add" onclick="adicionarCampo01()" class="btn btn-success " style="width: 100%;margin-bottom: 10px;"><i class="fa-solid fa-plus"></i> Adicionar mais tamanhos</button>
                                     </div>
                                     <div class="row">

                                         <div class="col-sm-8">
                                             <div class="form-group" style="margin-bottom: 0.5rem;">
                                                 <label>Tamanho</label>
                                             </div>
                                         </div>
                                         <div class="col-sm-4">
                                             <div class="form-group" style="margin-bottom: 0.5rem;">
                                                 <label>Preço</label>
                                             </div>
                                         </div>
                                         <?php
                                            $count = count($getSizeProduct);
                                            foreach ($getSizeProduct as $key => $size) {
                                            ?>
                                             <div class="col-sm-8">
                                                 <div class="form-group">
                                                     <input type="hidden" name="id_tamanho[]" value="<?= $size['id_tamanho'] ?>">
                                                     <input type="text" class="form-control" name="product_size[]" id="tamanho" value="<?= $size['tamanho'] ?>" required>
                                                 </div>
                                             </div>
                                             <div class="col-sm-4">
                                                 <div class="form-group">
                                                     <div class="input-group">
                                                         <div class="input-group-prepend">
                                                             <span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
                                                         </div>
                                                         <input type="text" name="product_price[]" id="preco" class="money form-control" value="<?= number_format($size['valor_produto'], 2, ",", "."); ?>" inputmode="numeric" required>
                                                         <?php
                                                            if ($count > 1) { ?>
                                                             <div class="input-group-append">
                                                                 <button type="button" class="btn btn-danger input-group-text" onclick="confirmExclude('<?= BASE_URL . 'produtos/size_remove/' . $size['id_tamanho'] ?>')">
                                                                     <i class="fa-solid fa-trash"></i>
                                                                 </button>
                                                             </div>
                                                         <?php } ?>
                                                     </div>
                                                 </div>
                                             </div>
                                         <?php } ?>



                                     </div>
                                     <div id="plusplus"></div>
                                 </div>

                                 <div class="form-group">
                                     <label for="">Descrição produto</label>
                                     <textarea class="form-control" name="description" rows="5" placeholder="Descrição"><?= $product['descricao_produto']; ?></textarea>
                                 </div>

                                 <div class="form-group">
                                     <label for="">Editar foto do produto</label>
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
                                 <button type="submit" class="btn btn-success float-right"><i class="fa-solid fa-pen-to-square"></i> Editar produto</button>
                             </div>
                         </form>
                     <?php } ?>
                 </div>
             </div>





         </div>


     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->