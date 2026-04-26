import React, { useEffect, useRef, useState } from "react";
import { FaVolumeMute } from "react-icons/fa";
import { gsap } from "gsap";
import music from "../assets/musics/music.mp3";
import { PiVinylRecordDuotone } from "react-icons/pi";

export const musicController = {
    play: null,
    pause: null,
};

function MusicPlayer() {
    const audioRef = useRef(null);
    const isFadingOut = useRef(false);
    const [isPlaying, setIsPlaying] = useState(false);

    // =========================
    // PLAY (with fade in)
    // =========================
    const playMusic = () => {
        if (!audioRef.current) return;

        audioRef.current.volume = 0;
        audioRef.current.play();

        gsap.to(audioRef.current, {
            volume: 0.4,
            duration: 1.2,
        });

        setIsPlaying(true);
    };

    // =========================
    // PAUSE (with fade out)
    // =========================
    const pauseMusic = () => {
        if (!audioRef.current || isFadingOut.current) return;

        isFadingOut.current = true;

        gsap.to(audioRef.current, {
            volume: 0,
            duration: 0.5,
            onComplete: () => {
                audioRef.current.pause();
                setIsPlaying(false);
                isFadingOut.current = false;
            },
        });
    };

    // =========================
    // FORCE PAUSE (NO GSAP)
    // =========================
    const forcePause = () => {
        if (!audioRef.current) return;

        audioRef.current.pause();
        audioRef.current.volume = 0;

        setIsPlaying(false);
        isFadingOut.current = false;
    };

    // expose global controller
    musicController.play = playMusic;
    musicController.pause = pauseMusic;

    // =========================
    // HANDLE TAB / WINDOW STATE
    // =========================
    useEffect(() => {
        const handleVisibilityChange = () => {
            if (document.hidden) {
                forcePause();
            }
        };

        const handlePageHide = () => {
            forcePause();
        };

        document.addEventListener("visibilitychange", handleVisibilityChange);
        window.addEventListener("pagehide", handlePageHide);

        return () => {
            document.removeEventListener(
                "visibilitychange",
                handleVisibilityChange
            );
            window.removeEventListener("pagehide", handlePageHide);
        };
    }, []);

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
