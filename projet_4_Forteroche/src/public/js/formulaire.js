class Form {
    constructor(formOpen, form, cross, formUpdate, update, crossUpdate)
    {
        this.formOpen = document.querySelector(formOpen);
        this.form = document.querySelector(form);
        this.cross = document.querySelector(cross);
        this.formUpdate = document.querySelectorAll(formUpdate);
        this.update = document.querySelector(update);
        this.crossUpdate = document.querySelector(crossUpdate);
    }

    init(){
        this.formOpen.addEventListener('click', this.openForm.bind(this));
        this.cross.addEventListener('click', this.closeForm.bind(this));
        this.formUpdate.forEach(function(elem){
            elem.addEventListener('click', this.openUpdate.bind(this));
        }.bind(this));
        this.crossUpdate.addEventListener('click', this.closeUpdate.bind(this));
    }

    openForm(e){
        e.preventDefault();
        this.form.style.display="flex";
        // this.form.style.transition="all 0.5s ease-in";
    }

    closeForm(){
        this.form.style.display="none";
    }

    openUpdate(e) {
        e.preventDefault();
        this.update.style.display="flex";
        // this.update.style.transition="display 0.5s, linear";
    }

    closeUpdate() {
        this.update.style.display="none";
        // this.update.style.transition="all 0.5s ease-out";
    }

}
