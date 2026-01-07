import { MapContainer, TileLayer, Marker, Popup } from "react-leaflet";
import "leaflet/dist/leaflet.css";
import { MapPin } from "lucide-react";
import L from "leaflet";

import icon from "leaflet/dist/images/marker-icon.png";
import iconShadow from "leaflet/dist/images/marker-shadow.png";

let DefaultIcon = L.icon({
  iconUrl: icon,
  shadowUrl: iconShadow,
  iconSize: [25, 41],
  iconAnchor: [12, 41],
});

L.Marker.prototype.options.icon = DefaultIcon;

const InteractiveMap = ({ destinations }) => {
  const centerPosition = [-6.178306, 106.631889];

  return (
    <div className="w-full h-[400px] rounded-3xl overflow-hidden shadow-xl border-4 border-white dark:border-gray-800 relative z-0">
      <MapContainer
        center={centerPosition}
        zoom={11}
        scrollWheelZoom={false}
        className="w-full h-full z-0"
      >
        <TileLayer
          attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        />

        {destinations.map((item) => (
          <Marker key={item.id} position={[item.lat, item.lng]}>
            <Popup>
              <div className="text-center">
                <img
                  src={item.image}
                  alt={item.name}
                  className="w-full h-24 object-cover rounded-lg mb-2"
                />
                <h3 className="font-bold text-gray-900 text-sm">{item.name}</h3>
                <span className="text-xs text-primary font-semibold">
                  {item.category}
                </span>
                <p className="text-xs text-gray-600 mt-1">{item.description}</p>
              </div>
            </Popup>
          </Marker>
        ))}
      </MapContainer>

      <div className="absolute top-4 right-4 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md px-4 py-2 rounded-full shadow-lg z-[400] text-xs font-bold flex items-center gap-2">
        <MapPin size={14} className="text-red-500" />
        Peta Interaktif
      </div>
    </div>
  );
};

export default InteractiveMap;
