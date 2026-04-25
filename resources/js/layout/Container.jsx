import React from "react";
import MusicPlayer from "../sections/MusicPlayer";

function Container({ children }) {
  return (
    <div className="relative min-h-screen">
      <div className="flex justify-center items-center min-h-screen ">
        <div className="w-full max-w-lg min-h-screen  backdrop-blur-md shadow-xl overflow-hidden ">
          {children}
        </div>
      </div>
    </div>
  );
}

export default Container;
