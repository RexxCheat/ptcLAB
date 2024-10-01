class FormGenerator{
    constructor(formClassName = null){
        this.fieldType = null;
        this.totalField = 0;
        if (this.formClassName) {
            this.formClassName = '.'+formClassName;
        }else{
            this.formClassName = '.generate-form';
        }
    }


    extraFields(fieldType){
        this.fieldType = fieldType;
        var addNew = '';
        if (this.fieldType == 'file') {
            var field = `<select class="select2-multi-select" name="extensions" multiple>
                <option value="jpg">JPG</option>
                <option value="jpeg">JPEG</option>
                <option value="png">PNG</option>
                <option value="pdf">PDF</option>
                <option value="doc">DOC</option>
                <option value="docx">DOCX</option>
                <option value="txt">TXT</option>
                <option value="xlx">XLX</option>
                <option value="xlsx">XLSX</option>
                <option value="csv">CSV</option>
            </select>`;
            var title = `File Extensions <small class="text--danger">*</small> <small class="text-primary">(Separate each element by comma)</small>`;
        }else{
            var field = `<input type="text" name="options[]" class="form-control" required>`;
            addNew = `<button type="button" class="btn btn-sm btn--primary addOption"><i class="las la-plus me-0"></i></button>`;
            var title = `Add Options`;
        }

        var html = `
            <div class="d-flex justify-content-between flex-wrap">
                <label>${title}</label>
                ${addNew}
            </div>
            <div class="options mt-2">
                <div class="form-group">
                    <div class="input-group">
                        ${field}
                    </div>
                </div>
            </div>
        `;
        if(this.fieldType == 'text' || this.fieldType == 'textarea' || this.fieldType == ''){
            html = '';
        }

        return html;
    }

    addOptions(){
        return `
            <div class="form-group">
                <div class="input-group">
                    <input type="text" name="options[]" class="form-control" required>
                    <button class="btn btn--danger input-group-text removeOption"><i class="las la-times"></i></button>
                </div>
            </div>
        `;
    }

    formsToJson(form){
        var extensions = null;
        var options = [];
        this.fieldType = form.find('[name=form_type]').val();
        if(this.fieldType == 'file'){
            extensions = form.find('[name=extensions]').val();
        }

        if(this.fieldType == 'select' || this.fieldType == 'checkbox' || this.fieldType == 'radio'){
            var options = $("[name='options[]']").map(function(){return $(this).val();}).get();
        }
        var formItem = {
            type:this.fieldType,
            is_required:form.find('[name=is_required]').val(),
            label:form.find('[name=form_label]').val(),
            extensions:extensions,
            options:options,
            old_id:form.find('[name=update_id]').val()
        };
        return formItem;
    }

    makeFormHtml(formItem,updateId){
        if (formItem.old_id) {
            updateId = formItem.old_id;
        }
        var hiddenFields = `
            <input type="hidden" name="form_generator[is_required][]" value="${formItem.is_required}">
            <input type="hidden" name="form_generator[extensions][]" value="${formItem.extensions}">
            <input type="hidden" name="form_generator[options][]" value="${formItem.options}">
        `;
        var formsHtml = `
            ${hiddenFields}
            <div class="card-body">
                <div class="form-group">
                    <label>Label</label>
                    <input type="text" name="form_generator[form_label][]" class="form-control" value="${formItem.label}" readonly>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <input type="text" name="form_generator[form_type][]" class="form-control" value="${formItem.type}" readonly>
                </div>
                <div class="btn-group w-100">
                    <button type="button" class="btn btn--primary editFormData" data-form_item='${JSON.stringify(formItem)}' data-update_id="${updateId}"><i class="las la-pen"></i></button>
                    <button type="button" class="btn btn--danger removeFormData"><i class="las la-times"></i></button>
                </div>
            </div>
        `;
        var html = `
            <div class="col-md-4">
                <div class="card border mb-3" id="${updateId}">
                    ${formsHtml}
                </div>
            </div>
        `;
    
        if(formItem.old_id){
            html = formsHtml;
            $(`#${formItem.old_id}`).html(html);
        }else{
            $('.addedField').append(html);
        }
    }

    formEdit(element){
        this.showModal()
        var formItem = element.data('form_item');
        var form = $(this.formClassName);
        form.find('[name=form_type]').val(formItem.type);
        form.find('[name=form_label]').val(formItem.label);
        form.find('[name=is_required]').val(formItem.is_required);
        form.find('[name=update_id]').val(element.data('update_id'))
        var html = '';
        if (formItem.type == 'file') {
            html += `
                <div class="d-flex justify-content-between flex-wrap">
                    <label>File Extensions <small class="text--danger">*</small> <small class="text-primary">(Separate each element by comma)</small></label>
                </div>
                <div class="mt-2">
                    <div class="form-group">
                        <select class="select2-multi-select" name="extensions" multiple>
                            <option value="jpg">JPG</option>
                            <option value="jpeg">JPEG</option>
                            <option value="png">PNG</option>
                            <option value="pdf">PDF</option>
                            <option value="doc">DOC</option>
                            <option value="docx">DOCX</option>
                            <option value="txt">TXT</option>
                            <option value="xlx">XLX</option>
                            <option value="xlsx">XLSX</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>
                </div>
            `;
        }
        var i = 0;
        var optionItem = '';
        formItem.options.forEach(option => {
            var isRemove = '';
            if(i != 0){
                isRemove = `
                    <button class="btn btn--danger input-group-text removeOption"><i class="las la-times"></i></button>
                `;
            }
            if (i==0) {
                html += `
                    <div class="d-flex justify-content-between flex-wrap">
                        <label>Add Options</label>
                        <button type="button" class="btn btn-sm btn--primary addOption"><i class="las la-plus me-0"></i></button>
                    </div>
                `;
            }
            i += 1;
            optionItem += `
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="options[]" value="${option}" class="form-control" required>
                        ${isRemove}
                    </div>
                </div>
            `;
        });
        if (formItem.type != 'file') {
            html += `
                <div class="options mt-2">
                    ${optionItem}
                </div>
            `;
        }
        $('.generatorSubmit').text('Update');
        $('.extra_area').html(html);
        $('.extra_area').find('select').val(formItem.extensions);

    }


    resetAll(){
        $(formGenerator.formClassName).trigger("reset");
        $('.extra_area').html('');
        $('.generatorSubmit').text('Add');
        $('[name=update_id]').val('');
        
    }

    closeModal(){
        var modal = $('#formGenerateModal');
        modal.modal('hide');
    }

    showModal(){
        this.resetAll();
        var modal = $('#formGenerateModal');
        modal.modal('show');
    }
}