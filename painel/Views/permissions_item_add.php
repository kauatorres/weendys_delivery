 <!-- Content Header (Page header) -->
 <div class="content-header">
     <div class="container-fluid">
         <div class="row mb-2">
             <div class="col-sm-6">
                 <h1 class="m-0">Permissões <button class="btn btn-info btn-sm" onclick="window.history.back();"> <i class="fa-duotone fa-rotate-left"></i> Voltar</button></h1>
             </div><!-- /.col -->
         </div><!-- /.row -->
     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content-header -->

 <!-- Main content -->
 <div class="content">
     <div class="container-fluid">

         <div class="row">
             <div class="col-md-12">

                 <div class="callout callout-warning">
                     <h5>ATENÇÃO!</h5>

                     <p>Esta página foi desenvolvida para os programadores. Favor não alterar nada.</p>
                 </div>
                 <form method="POST" action="<?= BASE_URL . "permissions/itens_add_action"; ?>" novalidate="novalidate" autocomplete="off">
                     <!-- Default box -->
                     <div class="card ">
                         <div class="card-header">
                             <h3 class="card-title">Novo item de permissão</h3>
                             <div class="card-tools">
                                 <button type="submit" class="btn btn-block btn-success btn-sm"><i class="fa-regular fa-circle-check"></i> Adicionar</button>
                             </div>
                         </div>
                         <div class="card-body">

                             <div class="form-group has-error">
                                 <label for="exampleInputEmail1">Nome do item</label>
                                 <input type="text" class="form-control <?= (in_array('name', $errorItens) ? 'is-invalid' : '') ?>" id="group_name" name="name" placeholder="Nome do grupo">
                                 <span id="exampleInputEmail1-error" class="error invalid-feedback">Digite um nome para adicionar um item</span>
                             </div>

                             <hr>

                             <div class="form-group has-error">
                                 <label for="exampleInputEmail1">Slug</label>
                                 <input type="text" class="form-control <?= (in_array('name', $errorItens) ? 'is-invalid' : '') ?>" onkeypress="return urlInput.keyPress(event);" onkeyup="return urlInput.keyUp(this);" id="slug" name="slug" placeholder="Nome do slug">
                                 <span id="exampleInputEmail1-error" class="error invalid-feedback">Digite um slug para adicionar</span>
                             </div>

                         </div>
                         <!-- /.card-body -->
                     </div>
                     <!-- /.card -->
                 </form>
             </div>
         </div>


     </div><!-- /.container-fluid -->
 </div>
 <!-- /.content -->