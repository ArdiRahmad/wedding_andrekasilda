import React, { useEffect, useRef, useState } from "react";
import { useGSAP } from "@gsap/react";
import { gsap } from "gsap";

import Container from "../layout/Container";
import bgImage from "../assets/images/image1.png";
import ornament from "../assets/images/ornament.png";
import { IconWhite } from "../assets/images";

import { FaChevronDown, FaChevronUp } from "react-icons/fa";
import { musicController } from "./MusicPlayer";

function Intro() {
  const [isOpened, setIsOpened] = useState(false);

  useEffect(() => {
    document.body.style.overflow = isOpened ? "auto" : "hidden";
    return () => (document.body.style.overflow = "auto");
  }, [isOpened]);

  useGSAP(() => {
    if (isOpened) {
      gsap.to(".name-1", { opacity: 1, y: 0, duration: 0.8 });
      gsap.to(".name-2", { opacity: 1, y: 0, duration: 1, delay: 0.2 });
      gsap.to(".arrow-bottom", {
        opacity: 1,
        y: 0,
        duration: 1,
        delay: 0.3,
      });
      return;
    }

    const tl = gsap.timeline();
    tl.from(".logo", { y: -50, opacity: 0, duration: 1 })
      .from(".line", { scaleY: 0, opacity: 0, duration: 1.2 }, "-=0.6")
      .from(".cta", { y: 50, opacity: 0, duration: 1 }, "-=0.7")
      .from(".ornament", { y: 80, opacity: 0, duration: 1 }, "-=0.8");
  }, [isOpened]);

  const handleOpen = () => {
    if (isOpened) return;

    musicController.play?.();

    const tl = gsap.timeline({
      onComplete: () => setIsOpened(true),
    });

    tl.to([".line", ".cta", ".ornament"], {
      opacity: 0,
      y: -30,
      duration: 0.8,
      stagger: 0.1,
    })
      .to(".overlay", { opacity: 0, duration: 0.8 }, "<")
      .to(".bg-image", { scale: 1.15, duration: 1.2 }, "-=0.3");
  };

  return (
    <Container>
      <div
        onClick={handleOpen}
        className="min-h-screen flex flex-col relative overflow-hidden"
      >
        {/* BACKGROUND IMAGE (zoom target) */}
        <div
          className="bg-image absolute inset-0 bg-cover bg-center"
          style={{ backgroundImage: `url('${bgImage}')` }}
        />

        {/* OVERLAY */}
        {!isOpened && (
          <div className="overlay absolute inset-0 bg-primary/90 z-10" />
        )}

        {/* LOGO */}
        <div className="absolute top-12 w-full z-20">
          <div className="flex justify-center">
            <img className="w-[40%] logo" src={IconWhite} />
          </div>
        </div>

        {/* LINE */}
        <div className="absolute inset-0 flex justify-center items-center z-10">
          <div className="line h-full w-[1px] bg-[#F7DABD] origin-top" />
        </div>

        {/* CONTENT */}
        <div className="relative z-20 flex flex-col items-center justify-center flex-1">
          <div className="cta w-full">
            <div className="bg-primary w-full text-center">
              <p className="text-white font-body text-sm py-1">
                KLIK UNTUK MEMBUKA UNDANGAN
              </p>
            </div>
          </div>
        </div>

        {/* ORNAMENT */}
        <div className="absolute bottom-[-40px] w-full flex justify-center z-20">
          <img className="ornament" src={ornament} />
        </div>

        {isOpened && (
          <div className="invite-text absolute inset-x-0 bottom-0 h-[45vh] z-30">
            {/* GRADIENT */}
            <div className="absolute inset-0 bg-gradient-to-t from-primary/90 via-primary/80 to-transparent" />

            {/* CONTENT */}
            <div className="absolute left-1/2 top-1/2 -translate-x-1/2 text-center text-white font-content font-light w-full">
              <p className="text-sm opacity-0 name-1">Kepada Yth.</p>
              <p className="text-lg opacity-0 name-2 mb-4">
                Bapak Budi Sudirman
              </p>
              <div className="flex items-center flex-col arrow-bottom opacity-0">
                <FaChevronUp className="-mt-2.5 w-5 h-5 animate-pulse [animation-duration:1s]" />
                <FaChevronUp className="-mt-2.5 w-5 h-5 animate-pulse [animation-duration:2.5s]" />
              </div>
            </div>
          </div>
        )}
      </div>
    </Container>
  );
}

export default Intro;
