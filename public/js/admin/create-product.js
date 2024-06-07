
const addSpecBtn = document.getElementById('add-spec-btn');
const specs = document.getElementById('specs');

addSpecBtn.addEventListener('click', function() {

    let newInputGroup = document.createElement('div');
    newInputGroup.className='input-group mb-3';

    newInputGroup.innerHTML = '<span class="input-group-text">Name;Value</span> ' +
                            '<input type="text" class="form-control" name="specs[]" placeholder="Ex. color;blue">' +
                            '<span class="input-group-text btn btn-danger" style="cursor:pointer" onclick="removeInputGroup(this)"><i class="fa-solid fa-trash-can"></i></span>' ;
    specs.appendChild(newInputGroup);
});

function removeInputGroup(element) {
    const inputGroup = element.closest('.input-group');
    if (inputGroup) {
        inputGroup.remove();
    }
}
