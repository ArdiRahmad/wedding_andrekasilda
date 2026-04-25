import React, { useMemo, useState, useLayoutEffect } from "react";
import Container from "../layout/Container";
import {
  Flower1,
  Flower2,
  IconWhite,
  Image10,
  Image2,
  Image3,
  Image4,
  Image6,
  Image7,
  Image8,
  Image9,
} from "../assets/images";

import Masonry from "react-masonry-css";
import Lightbox from "yet-another-react-lightbox";

import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function Gallery() {
  const [index, setIndex] = useState(-1);

  const images = [
    { src: Image2 },
    { src: Image3 },
    { src: Image4 },
    { src: Image6 },
    { src: Image7 },
    { src: Image8 },
    { src: Image9 },
    { src: Image10 },
  ];

  const ratios = [
    "aspect-square",
    "aspect-[4/3]",
    "aspect-[3/4]",
    "aspect-video",
  ];

  const getRandomRatio = () =>
    ratios[Math.floor(Math.random() * ratios.length)];

  const imageWithRatio = useMemo(() => {
    return images.map((img) => ({
      ...img,
      ratio: getRandomRatio(),
    }));
  }, []);

  // 🔥 ANIMATION
  useLayoutEffect(() => {
    const ctx = gsap.context(() => {
      // 🌸 PARALLAX FLOWERS (smooth follow scroll)
      gsap.to(".flower-left", {
        y: -80,
        ease: "none",
        scrollTrigger: {
          trigger: ".gallery-section",
          start: "top bottom",
          end: "bottom top",
          scrub: true,
        },
      });

      gsap.to(".flower-right", {
        y: -120,
        ease: "none",
        scrollTrigger: {
          trigger: ".gallery-section",
          start: "top bottom",
          end: "bottom top",
          scrub: true,
        },
      });

      gsap.to(".flower-bottom", {
        y: 60,
        ease: "none",
        scrollTrigger: {
          trigger: ".gallery-section",
          start: "top bottom",
          end: "bottom top",
          scrub: true,
        },
      });

      // 🖼️ GALLERY ITEMS (clean stagger)
      gsap.from(".gallery-item", {
        opacity: 0,
        y: 40,
        scale: 0.95,
        stagger: 0.08,
        scrollTrigger: {
          trigger: ".gallery-grid",
          start: "top 90%",
          toggleActions: "play none none reverse",
        },
      });

      // 📜 TEXT QUOTE
      gsap.from(".gallery-text", {
        opacity: 0,
        y: 30,
        scrollTrigger: {
          trigger: ".gallery-text",
          start: "top 90%",
          toggleActions: "play none none reverse",
        },
      });
    });

    return () => ctx.revert();
  }, []);

  return (
    <Container>
      <div className="gallery-section min-h-screen bg-white relative overflow-hidden">
        {/* 🌸 FLOWERS */}
        <img
          src={Flower1}
          className="flower-left w-[317px] rotate-[180deg] translate-y-[-120px] absolute"
        />

        <img
          src={Flower1}
          className="flower-right w-[317px] translate-y-[450px] right-[-50px] absolute"
        />

        <img
          src={Flower2}
          className="flower-bottom w-[317px] -bottom-14 -left-20 absolute"
        />

        {/* overlay */}
        <div className="absolute inset-0 bg-primary/90 z-0" />

        <div className="relative z-10 px-10 py-14">
          {/* HEADER */}
          <div className="flex justify-center mb-8">
            <img className="w-[40%]" src={IconWhite} />
          </div>

          {/* 🖼️ GALLERY */}
          <Masonry
            breakpointCols={{ default: 4, 1024: 3, 640: 2, 0: 1 }}
            className="gallery-grid flex -ml-1 mb-6"
            columnClassName="pl-1"
          >
            {imageWithRatio.map((img, i) => (
              <div
                key={i}
                onClick={() => setIndex(i)}
                className="gallery-item mb-1 cursor-pointer"
              >
                <div className={`${img.ratio} overflow-hidden`}>
                  <img
                    src={img.src}
                    alt=""
                    className="w-full h-full object-cover transition-transform duration-500 hover:scale-110"
                  />
                </div>
              </div>
            ))}
          </Masonry>

          {/* 🔍 LIGHTBOX */}
          <Lightbox
            index={index}
            slides={images}
            open={index >= 0}
            close={() => setIndex(-1)}
          />

          {/* 📜 QUOTE */}
          <div className="gallery-text text-center px-4 border-y-white border-y py-4">
            <p className="font-body font-bold text-white text-2xl mb-5">
              on the path of love
            </p>

            <div className="text-xs text-white text-center font-dancing">
              <p className="mb-4 px-4">
                "Demikianlah mereka bukan lagi dua, melainkan satu. Karena itu,
                apa yang telah dipersatukan Allah, tidak boleh diceraikan
                manusia."
              </p>
              <p>Matius 19:6</p>
            </div>
          </div>
        </div>
      </div>
    </Container>
  );
}

export default Gallery;
