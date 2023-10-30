// Función para cargar dinámicamente los departamentos
function cargarDepartamentos(provinciaNombre) {
  // Ruta al archivo PHP que manejará la solicitud
  const url = 'http://localhost/inet/id_Desde_Descrip.php?provincia=' + provinciaNombre;

  // Obtener el desplegable de departamentos
  const selectDepartamento = document.getElementById('select-departamento');
  selectDepartamento.innerHTML = ''; // Limpiar opciones existentes

  // Agregar el valor predeterminado "Seleccionar un departamento"
  const defaultOption = document.createElement('option');
  defaultOption.value = "-1";
  defaultOption.text = "Seleccionar un departamento";
  selectDepartamento.appendChild(defaultOption);

  console.log('URL para cargar departamentos:', url);

  // Realizar la solicitud AJAX para cargar departamentos
  fetch(url)
    .then((response) => response.text())
    .then((data) => {
      // Agregar las opciones de departamentos desde la respuesta
      selectDepartamento.innerHTML += data;
      console.log('Respuesta de cargar departamentos:', data);
    })
    .catch((error) => {
      console.error('Error al cargar los departamentos:', error);
    });
}

// Función para cargar dinámicamente las localidades
function cargarLocalidades(provinciaNombre, departamento) {
  // Ruta al archivo PHP que manejará la solicitud
  console.log('Se disparó cargar localidades');
  const url = 'http://localhost/inet/Localidades.php?provincia=' + provinciaNombre + '&departamento=' + departamento;

  // Obtener el desplegable de localidades
  const selectLocalidad = document.getElementById('select-localidad');
  selectLocalidad.innerHTML = ''; // Limpiar opciones existentes

  // Agregar el valor predeterminado "Seleccione una localidad"
  const defaultOption = document.createElement('option');
  defaultOption.value = "-1";
  defaultOption.text = "Seleccionar una localidad";
  selectLocalidad.appendChild(defaultOption);

  console.log('URL para cargar localidades:', url);

  // Realizar la solicitud AJAX para cargar localidades
  fetch(url)
    .then((response) => response.text())
    .then((data) => {
      // Agregar las opciones de localidades desde la respuesta
      selectLocalidad.innerHTML += data;
      console.log('Respuesta de cargar localidades:', data);
    })
    .catch((error) => {
      console.error('Error al cargar las localidades:', error);
    });
}


// Evento para cambiar el departamento
document.getElementById('select-departamento').addEventListener('change', function(event) {
  const selectProvincia = document.getElementById('select-provincia');
  const provinciaNombre = selectProvincia.options[selectProvincia.selectedIndex].text;
  const departamentoNombre = event.target.options[event.target.selectedIndex].text;

  // Verificar que se hayan seleccionado tanto la provincia como el departamento
  if (provinciaNombre !== "Seleccione un lugar:" && departamentoNombre !== "Seleccione un departamento:") {
    cargarLocalidades(provinciaNombre, departamentoNombre);
  }
});

// Evento para cambiar la localidad
document.getElementById('select-localidad').addEventListener('change', function(event) {
  const selectProvincia = document.getElementById('select-provincia');
  const selectDepartamento = document.getElementById('select-departamento');
  const selectLocalidad = event.target;

  const provinciaNombre = selectProvincia.options[selectProvincia.selectedIndex].text;
  const departamentoNombre = selectDepartamento.options[selectDepartamento.selectedIndex].text;
  const localidadNombre = selectLocalidad.options[selectLocalidad.selectedIndex].text;

  // Verificar que se hayan seleccionado la provincia, el departamento y la localidad
  if (provinciaNombre !== "Seleccione un lugar:" && departamentoNombre !== "Seleccione un departamento:" && localidadNombre !== "Seleccione una localidad:") {
    // Realizar la solicitud AJAX para cargar los nombres de las instituciones
    cargarNombresInstituciones(provinciaNombre, departamentoNombre, localidadNombre);
  }
});

// Función para cargar dinámicamente los nombres de las instituciones y agregar marcadores
function cargarNombresInstituciones(provinciaNombre, departamentoNombre, localidadNombre) {
  // Ruta al archivo PHP que manejará la solicitud para obtener los nombres de las instituciones
  const url = `ttp://localhost/inet/Institucion.php?juridiccion=${provinciaNombre}&departamento=${departamentoNombre}&localidad=${localidadNombre}`;

  // Realizar la solicitud AJAX para cargar los nombres de las instituciones
  fetch(url)
    .then((response) => response.text())
    .then((data) => {
      // Aquí puedes manejar la respuesta con los nombres de las instituciones
      // Por ejemplo, agregar marcadores en el mapa
      const namesArray = data.split('<br>');
      namesArray.pop(); // Elimina el último elemento vacío

      namesArray.forEach((nombre) => {
        // Calcula las coordenadas para el marcador (ajusta la distancia según sea necesario)
        const offsetLat = Math.random() * 0.02 - 0.01;
        const offsetLng = Math.random() * 0.02 - 0.01;

        // Agregar un marcador con el nombre de la institución como título
        const dynamicMarker = L.marker([parseFloat(latitude) + offsetLat, parseFloat(longitude) + offsetLng]).addTo(map);
        dynamicMarker.bindPopup(`<h2>${nombre}</h2>`);
      });
    })
    .catch((error) => {
      console.error('Error al cargar los nombres de las instituciones:', error);
    });
}
