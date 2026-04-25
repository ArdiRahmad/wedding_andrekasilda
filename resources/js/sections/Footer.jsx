import React, { useLayoutEffect } from "react";
import { IconWhite, Image10, Image8 } from "../assets/images";

import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function Footer() {
  useLayoutEffect(() => {
    const ctx = gsap.context(() => {
      // 🌄 IMAGE ZOOM (cinematic slow zoom)
      gsap.fromTo(
        ".footer-image",
        { scale: 1.2 },
        {
          scale: 1,
          ease: "none",
          scrollTrigger: {
            trigger: ".footer-section",
            start: "top bottom",
            end: "bottom top",
            scrub: true,
          },
        }
      );

      // 🌿 ICON
      gsap.from(".footer-icon", {
        opacity: 0,
        y: 20,
        duration: 1,
        scrollTrigger: {
          trigger: ".footer-icon",
          start: "top 90%",
        },
      });

      // ✨ TITLE
      gsap.from(".footer-title", {
        opacity: 0,
        y: 25,
        duration: 1,
        scrollTrigger: {
          trigger: ".footer-title",
          start: "top 90%",
        },
      });

      // 📜 TEXT
      gsap.from(".footer-text", {
        opacity: 0,
        y: 30,
        stagger: 0.1,
        scrollTrigger: {
          trigger: ".footer-text",
          start: "top 90%",
        },
      });
    });

    return () => ctx.revert();
  }, []);

  return (
    <div className="footer-section relative min-h-screen">
      <div className="flex min-h-screen justify-center items-center">
        <div className="w-full max-w-lg backdrop-blur-md shadow-xl overflow-hidden">
          <div className="text-center">
            {/* IMAGE */}
            <div className="w-full h-screen overflow-hidden relative">
              {/* TEXT OVERLAY */}
              <div className="absolute top-0 bottom-0 z-10 flex items-center justify-center px-14 flex-col">
                {/* ICON */}
                <div className="footer-icon flex items-center justify-center mb-8">
                  <img className="w-[40%]" src={IconWhite} />
                </div>

                {/* TITLE */}
                <p className="footer-title font-body font-bold text-white text-2xl mb-5">
                  THANK YOU
                </p>

                {/* TEXT */}
                <p className="footer-text text-xs text-white text-center font-dancing leading-relaxed">
                  Kami mengucapkan terimakasih kepada Bapak/Ibu/Saudara yang
                  telah menghadiri seluruh rangkaian acara pernikahan kami.
                  Semoga waktu yang diberikan menjadi berkah dan manfaat yang
                  dibalas oleh Tuhan Yang Maha Esa. Terima kasih atas seluruh
                  doa dan ucapan yang diberikan :)
                </p>
              </div>

              {/* OVERLAY */}
              <div className="w-full h-60 inset-0 bg-primary/70 z-0 absolute" />

              {/* IMAGE */}
              <img
                src={Image8}
                className="footer-image w-full h-full object-cover"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Footer;
