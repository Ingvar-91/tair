<!--Редактирование категории-->
<div class="modal fade" id="category-edit-wd" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Редактирование категории</h4>
            </div>
            <div class="modal-body">
                <form autocomplete="off" method="post" enctype="multipart/form-data" action="" id="category-edit-form">
                    
                    <input type="hidden" id="category-edit-wd-id" name="id" value="">

                    <div class="form-group">
                        <label class="control-label">Наименование * </label>
                        <input title="Введите наименование" name="title" id="category-edit-wd-name" class="form-control" type="text"/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Родительская категория *</label>
                        <select title="Выберите категорию" id="category-edit-wd-select" name="parent_id" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <input name="image" id="category-edit-input-file" type="file" class="form-control" accept="image/png, image/jpeg, image/gif"/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input class="btn btn-info" id="category-save" value="Сохранить" type="button">
            </div>
        </div>
    </div>
</div>
