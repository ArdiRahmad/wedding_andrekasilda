import React, { useEffect, useLayoutEffect, useRef, useState } from "react";
import { Image10, Image8, Image9, Ornament1 } from "../assets/images";

import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { FaGift } from "react-icons/fa";

gsap.registerPlugin(ScrollTrigger);

function Gift() {
  const [isOpen, setIsOpen] = useState(false);
  const modalRef = useRef(null);
  const backdropRef = useRef(null);
  const [copiedIndex, setCopiedIndex] = useState(null);

  const accounts = [
    { bank: "MANDIRI", number: "171001179613" },
    { bank: "BRI", number: "626801006152508" },
    { bank: "BCA", number: "0332816827" },
  ];
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

  useEffect(() => {
    if (!modalRef.current || !backdropRef.current) return;

    if (isOpen) {
      gsap.to(backdropRef.current, {
        opacity: 1,
        pointerEvents: "auto",
        duration: 0.25,
      });

      gsap.fromTo(
        modalRef.current,
        { opacity: 0, scale: 0.95, y: 20 },
        { opacity: 1, scale: 1, y: 0, duration: 0.3, ease: "power2.out" }
      );
    } else {
      gsap.to(modalRef.current, {
        opacity: 0,
        scale: 0.95,
        y: 20,
        duration: 0.2,
      });

      gsap.to(backdropRef.current, {
        opacity: 0,
        pointerEvents: "none",
        duration: 0.2,
      });
    }
  }, [isOpen]);

  const handleCopy = async (number, index) => {
    try {
      await navigator.clipboard.writeText(number);
      setCopiedIndex(index);
      setTimeout(() => setCopiedIndex(null), 2000);
    } catch (err) {
      console.error(err);
    }
  };

  return (
    <div className="story-section relative">
      <div className="flex justify-center items-center">
        <div className="w-full max-w-lg backdrop-blur  shadow-xl overflow-hidden">
          <div className="text-center">
            <div className="w-full h-60 overflow-hidden relative z-10">
              {/* TEXT */}
              <div className="absolute top-0 bottom-0 z-10 flex items-center justify-center px-10 flex-col">
                <p className="font-body font-bold text-white text-2xl mb-5">
                  GIFT
                </p>

                <p className="text-xs text-white text-center font-dancing mb-6">
                  Bapak/Ibu/Saudara sekalian dapat memberikan hadiah digital
                  kepada kami melalui form dibawah. Bagi yang telah mengisi dan
                  memberikan hadiah kepada kami, kami mengucapkan banyak
                  terimakasih. Semoga hadiah dari Bapak/Ibu/Saudara dapat
                  bermanfaat bagi kami dalam mengarungi bahtera rumah tangga
                </p>
              </div>
              <div className="absolute w-full h-full z-10">
                <div className="flex justify-between">
                  <img src={Ornament1} className="w-[20%] story-image " />
                  <img
                    src={Ornament1}
                    className="w-[20%] rotate-90 story-image right-0"
                  />
                </div>
                <div>
                  <img
                    src={Ornament1}
                    className="w-[20%] story-image -rotate-90 absolute bottom-0"
                  />
                  <img
                    src={Ornament1}
                    className="w-[20%] story-image -rotate-180 absolute bottom-0 right-0"
                  />
                </div>
              </div>

              <div className="z-20 bottom-4 left-0 right-0 absolute">
                <button
                  onClick={() => setIsOpen(true)}
                  className="event-button bg-brown-dark px-14 py-2 text-white text-xs"
                >
                  GIFT
                </button>
              </div>
              {/* OVERLAY */}
              <div className="w-full h-60 inset-0 bg-primary/60 z-5 absolute" />

              {/* IMAGE */}
              <img
                src={Image8}
                className="story-image w-full h-full object-cover "
              />
            </div>
          </div>
        </div>
      </div>
      <div
        ref={backdropRef}
        className="fixed inset-0 bg-black/50 opacity-0 pointer-events-none flex items-center justify-center z-20"
      >
        <div
          ref={modalRef}
          className="bg-white p-6 rounded-lg shadow-lg opacity-0 w-[90%]"
        >
          <div className="flex justify-center gap-2 text-brown mb-4">
            <FaGift />
            <p className="font-body font-bold text-2xl">GIFT</p>
          </div>

          {accounts.map((item, i) => (
            <div key={i} className="p-3 border mb-3 rounded-lg font-content">
              <p className="text-xs">{item.bank}</p>
              <p className="text-xs font-semibold">{item.number}</p>

              <button
                onClick={() => handleCopy(item.number, i)}
                className="text-xs mt-2 border px-2 py-1"
              >
                {copiedIndex === i ? "Copied!" : "Copy"}
              </button>
            </div>
          ))}

          <button
            onClick={() => setIsOpen(false)}
            className="bg-brown-dark text-white w-full py-2 text-xs"
          >
            CLOSE
          </button>
        </div>
      </div>
    </div>
  );
}

export default Gift;
