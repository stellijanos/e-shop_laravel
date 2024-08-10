function removeInputGroup(btn) {
    const inputGroup = btn.closest(".input-group");
    if (inputGroup) {
        inputGroup.remove();
    }
}

function addInputGroup(specs) {
    let newInputGroup = document.createElement("div");
    newInputGroup.className = "input-group mb-3";

    newInputGroup.innerHTML =
        '<span class="input-group-text">Name;Value</span> ' +
        '<input type="text" class="form-control" name="specs[]" placeholder="Ex. color;blue">' +
        '<span class="input-group-text btn btn-danger remove-spec" style="cursor:pointer"><i class="fa-solid fa-trash-can"></i></span>';
    specs.appendChild(newInputGroup);

    newInputGroup.querySelector('.remove-spec').addEventListener("click", function () {
        removeInputGroup(newInputGroup);    
    });
}

export default function () {
    const addSpecBtn = document.getElementById("add-spec-btn");
    const removeInputBtns = document.querySelectorAll(".remove-spec");
    const specs = document.getElementById("specs");

    addSpecBtn.addEventListener("click", function () {
        addInputGroup(specs);
    });

    removeInputBtns.forEach((btn) => {
        btn.addEventListener("click", function () {
            removeInputGroup(btn);
        });
    });
}
