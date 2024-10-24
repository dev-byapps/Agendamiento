document.addEventListener('DOMContentLoaded', function () {
    const grid = GridStack.init();  // La inicialización se mantiene con init() en la versión 10.x

    document.getElementById('addGroup').addEventListener('click', function () {
        addGroup(grid);
    });

    function addGroup(grid) {
        let groupId = new Date().getTime(); // Generar un ID único
        let groupElement = document.createElement('div');
        groupElement.className = 'grid-stack-item';
        groupElement.innerHTML = `
            <div class="grid-stack-item-content">
                <div class="group-header">
                    <input type="text" value="Grupo ${groupId}" />
                    <button class="deleteGroup btn">Eliminar</button>
                </div>
                <div class="cards"></div>
                <button class="addCard btn">Agregar Ficha</button>
            </div>
        `;

        grid.addWidget(groupElement, { w: 3, h: 2 });  // El nuevo formato usa "w" y "h" en lugar de "width" y "height"

        // Funcionalidad para eliminar grupo
        groupElement.querySelector('.deleteGroup').addEventListener('click', function () {
            grid.removeWidget(groupElement);
        });

        // Funcionalidad para agregar fichas
        groupElement.querySelector('.addCard').addEventListener('click', function () {
            addCard(groupElement.querySelector('.cards'));
        });
    }

    function addCard(cardContainer) {
        let cardElement = document.createElement('div');
        cardElement.className = 'card';
        cardElement.innerHTML = `
            <span>Ficha con valor</span>
            <button class="deleteCard btn">X</button>
        `;

        cardContainer.appendChild(cardElement);

        // Funcionalidad para eliminar ficha
        cardElement.querySelector('.deleteCard').addEventListener('click', function () {
            cardElement.remove();
        });

        // Cambiar color y estado de la ficha
        cardElement.addEventListener('click', function () {
            cardElement.style.backgroundColor = cardElement.style.backgroundColor === 'green' ? '#f8d7da' : 'green';
        });
    }
});
