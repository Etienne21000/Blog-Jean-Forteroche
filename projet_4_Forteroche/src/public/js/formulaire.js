document.addEventListener('DOMContentLoaded', function(){

    class Form {
        constructor(formOpen, form, cross)
        {
            this.formOpen = document.querySelector('.js-form');
            this.form = document.querySelector('#form');
            this.cross = document.querySelector('#cross');
        }

        init(){
            this.formOpen.addEventListener('click', this.openForm.bind(this));
            this.cross.addEventListener('click', this.closeForm.bind(this));
            // this.formUpdate.forEach(function(elem){
            //     elem.addEventListener('click', this.openUpdate.bind(this));
            // }.bind(this));
            // this.crossUpdate.addEventListener('click', this.closeUpdate.bind(this));
        }

        openForm(e){
            e.preventDefault();
            this.form.style.display="flex";
        }

        closeForm(){
            this.form.style.display="none";
        }

    };

    var newForm = new Form();
    newForm.init();

});
