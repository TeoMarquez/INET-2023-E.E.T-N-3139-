// Crear el mapa
let map = L.map('map').setView([-34.98490511769442, -63.691350039494324], 4);

// Agregar una capa de OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Función para agregar un marcador en una ubicación específica
function addMarker(latitude, longitude, title, address, contact) {
  let marker = L.marker([latitude, longitude]).addTo(map);
  marker.bindPopup(`<h2>${title}</h2><p>Dirección: ${address}</p><p>Contacto: ${contact}</p>`);
}

// Evento para cambiar la ubicación y agregar un marcador
document.getElementById('select-provincia').addEventListener('change', function() {
    console.log('Cambió el selector de provincia');
    var selectedOption = this.options[this.selectedIndex];
    var provinciaNombre = selectedOption.text; // Obtener el texto de la opción seleccionada
  
    var latitude = parseFloat(selectedOption.value.split(',')[0]);
    var longitude = parseFloat(selectedOption.value.split(',')[1]);
  
    if (!isNaN(latitude) && !isNaN(longitude)) {
      // Centrar el mapa en la nueva ubicación
      map.flyTo([latitude, longitude], 13);
  
      // Limpiar los marcadores existentes antes de agregar uno nuevo
      map.eachLayer((layer) => {
        if (layer instanceof L.Marker) {
          map.removeLayer(layer);
        }
      });
  
      // Agregar un nuevo marcador en la ubicación
      addMarker(latitude, longitude, provinciaNombre, '', '');
  
      // Cargar dinámicamente los departamentos después de centrar el mapa
      cargarDepartamentos(provinciaNombre);
    }
  });