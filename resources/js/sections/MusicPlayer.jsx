import React, { useEffect, useRef, useState } from "react";
import { FaVolumeMute } from "react-icons/fa";
import { gsap } from "gsap";
import music from "../assets/musics/music.mp3";
import { PiVinylRecordDuotone } from "react-icons/pi";

export const musicController = {
    play: null,
    pause: null,
    isReady: false,
    _pendingPlay: false,
};

function MusicPlayer() {
    const audioRef = useRef(null);
    const isFadingOut = useRef(false);
    const [isPlaying, setIsPlaying] = useState(false);

    // =========================
    // PLAY
    // =========================
    const playMusic = async () => {
        if (!audioRef.current) return;

        try {
            audioRef.current.volume = 0;
            await audioRef.current.play();

            gsap.to(audioRef.current, {
                volume: 0.4,
                duration: 1.2,
            });

            setIsPlaying(true);
        } catch (err) {
            console.log("Play blocked:", err);
        }
    };

    // =========================
    // PAUSE
    // =========================
    const pauseMusic = () => {
        if (!audioRef.current || isFadingOut.current) return;

        isFadingOut.current = true;

        gsap.killTweensOf(audioRef.current);

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

    const forcePause = () => {
        if (!audioRef.current) return;

        gsap.killTweensOf(audioRef.current);

        audioRef.current.pause();
        audioRef.current.volume = 0;

        setIsPlaying(false);
        isFadingOut.current = false;
    };

    // =========================
    // REGISTER CONTROLLER (IMPORTANT FIX)
    // =========================
    useEffect(() => {
        musicController.play = playMusic;
        musicController.pause = pauseMusic;
        musicController.isReady = true;

        // 🔥 IMPORTANT: kalau ada request sebelum ready
        if (musicController._pendingPlay) {
            musicController._pendingPlay = false;
            playMusic();
        }

        return () => {
            musicController.play = null;
            musicController.pause = null;
            musicController.isReady = false;
        };
    }, []);

    // =========================
    // HANDLE TAB SWITCH
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
