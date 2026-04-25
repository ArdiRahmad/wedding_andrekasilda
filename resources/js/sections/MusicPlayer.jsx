import React, { useRef, useState } from "react";
import { FaMusic, FaVolumeMute } from "react-icons/fa";
import { gsap } from "gsap";
import music from "../assets/musics/music.mp3";
import { PiVinylRecordDuotone, PiVinylRecordThin } from "react-icons/pi";

export const musicController = {
  play: null,
  pause: null,
};

function MusicPlayer() {
  const audioRef = useRef(null);
  const [isPlaying, setIsPlaying] = useState(false);

  const playMusic = () => {
    if (!audioRef.current) return;

    audioRef.current.play();
    audioRef.current.volume = 0;

    gsap.to(audioRef.current, {
      volume: 0.4,
      duration: 1.5,
    });

    setIsPlaying(true);
  };

  const pauseMusic = () => {
    gsap.to(audioRef.current, {
      volume: 0,
      duration: 0.5,
      onComplete: () => {
        audioRef.current.pause();
        setIsPlaying(false);
      },
    });
  };

  // expose global controller
  musicController.play = playMusic;
  musicController.pause = pauseMusic;

  return (
    <>
      <audio ref={audioRef} loop>
        <source src={music} type="audio/mpeg" />
      </audio>

      <button
        onClick={() => (isPlaying ? pauseMusic() : playMusic())}
        className="fixed bottom-6 right-6 z-[9999] bg-primary text-white p-3 rounded-full shadow-lg"
      >
        {isPlaying ? (
          <PiVinylRecordDuotone className="animate-spin [animation-duration:2.5s]" />
        ) : (
          <FaVolumeMute />
        )}
      </button>
    </>
  );
}

export default MusicPlayer;
