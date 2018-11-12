<!--Редактирование категории-->
<div class="modal fade" id="category-edit-wd" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Редактирование категории</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="category-edit-wd-id" value="">

                <div class="form-group">
                    <label class="control-label">Наименование * </label>
                    <input title="Введите наименование" name="title" id="category-edit-wd-name" class="form-control" type="text"/>
                </div>
                <div class="form-group">
                    <label class="control-label">Родительская категория *</label>
                    <select title="Выберите категорию" id="category-edit-wd-select" name="parent_id" class="form-control"></select>
                </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-info" id="category-save" value="Сохранить" type="button">
            </div>
        </div>
    </div>
</div>
