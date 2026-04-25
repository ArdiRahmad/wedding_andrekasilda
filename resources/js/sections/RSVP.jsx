import React, { useEffect, useRef, useState, useLayoutEffect } from "react";
import { Flower1, IconColor } from "../assets/images";
import Container from "../layout/Container";
import { Autoplay, EffectFade, Pagination } from "swiper/modules";
import { Swiper, SwiperSlide } from "swiper/react";

import "swiper/css";
import "swiper/css/effect-fade";
import "swiper/css/pagination";

import { FaEnvelopeOpen, FaGift } from "react-icons/fa";
import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const wishes = [
  { name: "Budi", wish: "Semoga hari kamu penuh kebahagiaan ✨" },
  { name: "Roi", wish: "Semoga hari kamu penuh kebahagiaan ✨" },
  { name: "Nico", wish: "Semoga hari kamu penuh kebahagiaan ✨" },
];

function RSVP() {
  const [isOpen, setIsOpen] = useState(false);
  const modalRef = useRef(null);
  const backdropRef = useRef(null);
  const [copiedIndex, setCopiedIndex] = useState(null);

  const accounts = [
    { bank: "MANDIRI", number: "171001179613" },
    { bank: "BRI", number: "626801006152508" },
    { bank: "BCA", number: "0332816827" },
  ];

  // 🎬 MODAL ANIMATION (tetap GSAP tapi lebih clean)
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

  // 🎞️ SCROLL ANIMATION
  useLayoutEffect(() => {
    const ctx = gsap.context(() => {
      // 🌸 FLOWER PARALLAX
      // gsap.to(".rsvp-flower-left", {
      //   y: -80,
      //   ease: "none",
      //   scrollTrigger: {
      //     trigger: ".rsvp-section",
      //     start: "top bottom",
      //     end: "bottom top",
      //     scrub: true,
      //   },
      // });

      // gsap.to(".rsvp-flower-right", {
      //   y: -120,
      //   ease: "none",
      //   scrollTrigger: {
      //     trigger: ".rsvp-section",
      //     start: "top bottom",
      //     end: "bottom top",
      //     scrub: true,
      //   },
      // });

      // HEADER
      gsap.from(".rsvp-header", {
        opacity: 0,
        y: 30,
        scrollTrigger: {
          trigger: ".rsvp-header",
          start: "top 90%",
        },
      });

      // TITLE
      gsap.from(".rsvp-title", {
        opacity: 0,
        y: 20,
        stagger: 0.1,
        scrollTrigger: {
          trigger: ".rsvp-title",
          start: "top 90%",
        },
      });

      // SWIPER
      gsap.from(".rsvp-swiper", {
        opacity: 0,
        y: 40,
        scrollTrigger: {
          trigger: ".rsvp-swiper",
          start: "top 90%",
        },
      });

      // FORM
      gsap.from(".rsvp-field", {
        opacity: 0,
        y: 25,
        stagger: 0.12,
        scrollTrigger: {
          trigger: ".rsvp-form",
          start: "top 85%",
        },
      });

      // BUTTON
      gsap.from(".rsvp-button", {
        opacity: 0,
        scale: 0.9,
        scrollTrigger: {
          trigger: ".rsvp-button",
          start: "top 95%",
        },
      });
    });

    return () => ctx.revert();
  }, []);

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
    <Container>
      <div className="rsvp-section min-h-screen bg-white relative overflow-hidden">
        {/* 🌸 FLOWER */}
        <img
          src={Flower1}
          className="rsvp-flower-left w-[317px] rotate-[180deg] translate-y-[-120px] absolute"
        />
        <img
          src={Flower1}
          className="rsvp-flower-right w-[317px] translate-y-[500px] right-[-50px] absolute"
        />

        <div className="absolute inset-0 bg-white/70 z-0" />

        <div className="relative z-10 px-10 py-14 text-center">
          {/* HEADER */}
          <div className="rsvp-header flex justify-center mb-8">
            <img className="w-[40%]" src={IconColor} />
          </div>

          {/* WISHES */}
          <p className="rsvp-title font-body font-bold text-brown text-2xl mb-5">
            WISHES
          </p>

          <div className="rsvp-swiper w-full max-w-xl mx-auto mb-18">
            <Swiper
              effect="fade"
              fadeEffect={{ crossFade: true }}
              autoplay={{ delay: 3000, disableOnInteraction: false }}
              loop
              modules={[Autoplay, EffectFade]}
            >
              {wishes.map((text, i) => (
                <SwiperSlide key={i}>
                  <div className="text-center text-brown">
                    <p className="font-dancing text-sm px-6">{text.wish}</p>
                    <p className="font-dancing text-xl mt-2">{text.name}</p>
                  </div>
                </SwiperSlide>
              ))}
            </Swiper>
          </div>

          {/* RSVP TITLE */}
          <p className="rsvp-title font-body font-bold text-brown text-2xl mb-5">
            RSVP
          </p>

          {/* FORM */}
          <div className="rsvp-form flex flex-col text-brown font-content font-light">
            <div className="rsvp-field flex flex-col items-start mb-3">
              <label className="text-xs mb-2">NAMA</label>
              <input className="border border-brown p-2 w-full" />
            </div>

            <div className="rsvp-field flex flex-col items-start mb-3">
              <label className="text-xs mb-2">KEHADIRAN</label>
              <select className="border border-brown p-2 w-full">
                <option>-- Status Kehadiran --</option>
                <option>Hadir</option>
                <option>Tidak Hadir</option>
              </select>
            </div>
            <div className="rsvp-field flex flex-col items-start mb-3">
              <label className="text-xs mb-2">SIDE</label>
              <select className="border border-brown p-2 w-full">
                <option>-- Side --</option>
                <option>Groom</option>
                <option>Bride</option>
              </select>
            </div>
            <div className="rsvp-field flex flex-col items-start mb-3">
              <label className="text-xs mb-2">GIFT</label>

              <input type="file" className="border border-brown p-2 w-full" />
            </div>

            <div className="rsvp-field flex flex-col items-start mb-6">
              <label className="text-xs mb-2">UCAPAN</label>
              <textarea className="border border-brown p-2 w-full" />
            </div>

            <button className="rsvp-button bg-brown-dark px-14 py-2 text-white text-xs">
              SUBMIT
            </button>
          </div>
        </div>

        {/* MODAL */}
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
    </Container>
  );
}

export default RSVP;
