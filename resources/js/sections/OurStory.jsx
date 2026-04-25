import React, { useLayoutEffect } from "react";
import { Image10 } from "../assets/images";

import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function OurStory() {
  useLayoutEffect(() => {
    const ctx = gsap.context(() => {
      gsap.fromTo(
        ".story-image",
        { scale: 1.2 },
        {
          scale: 1,
          ease: "none",
          scrollTrigger: {
            trigger: ".story-section",
            start: "top bottom",
            end: "bottom top",
            scrub: true,
          },
        }
      );
    });

    return () => ctx.revert();
  }, []);

  return (
    <div className="story-section relative">
      <div className="flex justify-center items-center">
        <div className="w-full max-w-lg backdrop-blur-md shadow-xl overflow-hidden">
          <div className="text-center">
            <div className="w-full h-60 overflow-hidden relative">
              {/* TEXT */}
              <div className="absolute top-0 bottom-0 z-10 flex items-center justify-center px-14 flex-col">
                <p className="font-body font-bold text-white text-2xl mb-5">
                  OUR STORY
                </p>

                <p className="text-xs text-white text-center font-dancing">
                  Berawal dari pertemuan di SMA saat itu kasilda adalah Adik
                  kelas dari andre. Kami pertama kali berkenalan di acara reat
                  reat yang diadakan di SMA kami. Saat SMA dan awal berkuliah di
                  kampus masing masing awalnya kami tidak ada keterikatan satu
                  dengan yang lain. Hingga saat kuliah kami mulai berhubungan
                  kembali melalui sosial media dan menjalani masa pacaran hingga
                  sekarang.
                </p>
              </div>

              {/* OVERLAY */}
              <div className="w-full h-60 inset-0 bg-primary/60 z-5 absolute" />

              {/* IMAGE */}
              <img
                src={Image10}
                className="story-image w-full h-full object-cover"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default OurStory;
