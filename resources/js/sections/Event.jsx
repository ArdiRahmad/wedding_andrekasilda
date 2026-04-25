import React, { useEffect, useState } from "react";
import Container from "../layout/Container";
import { Flower1, IconColor } from "../assets/images";

import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function Event() {
  const weddingDate = new Date("2026-12-20T09:00:00").getTime();

  const [timeLeft, setTimeLeft] = useState(getTimeRemaining());

  function getTimeRemaining() {
    const now = new Date().getTime();
    const distance = weddingDate - now;

    if (distance <= 0) {
      return { days: 0, hours: 0, minutes: 0, seconds: 0 };
    }

    return {
      days: Math.floor(distance / (1000 * 60 * 60 * 24)),
      hours: Math.floor((distance / (1000 * 60 * 60)) % 24),
      minutes: Math.floor((distance / 1000 / 60) % 60),
      seconds: Math.floor((distance / 1000) % 60),
    };
  }

  useEffect(() => {
    const interval = setInterval(() => {
      setTimeLeft(getTimeRemaining());
    }, 1000);

    return () => clearInterval(interval);
  }, []);

  useEffect(() => {
    const ctx = gsap.context(() => {
      // FLOWER subtle parallax feel
      gsap.from("#flower-1, #flower-2", {
        scrollTrigger: {
          trigger: ".section-event",
          start: "top 85%",
          // scrub: 1,
        },
        opacity: 0,
        y: 80,
        scale: 0.9,
      });

      // HEADER ICON
      gsap.from(".event-header", {
        scrollTrigger: {
          trigger: ".section-event",
          start: "top 80%",
          // scrub: 1,
        },
        opacity: 0,
        y: 40,
        scale: 0.95,
        duration: 1.5,
      });

      // TITLE (Wedding Date + Date text)
      gsap.from(".title", {
        scrollTrigger: {
          trigger: ".section-event",
          start: "top 78%",
          // scrub: 1,
        },
        opacity: 0,
        y: 30,
        stagger: 0.15,
        duration: 1.6,
      });

      // COUNTDOWN BOXES (more premium stagger feel)
      gsap.from(".countdown-box", {
        scrollTrigger: {
          trigger: ".section-event",
          start: "top 72%",
          // scrub: 1,
        },
        opacity: 0,
        y: 20,
        scale: 0.85,
        stagger: 0.1,
        duration: 1.4,
      });

      // EVENT BLOCKS (RESEPSI + PEMBERKATAN)
      gsap.from(".event-block", {
        scrollTrigger: {
          trigger: ".section-event",
          start: "top 68%",
          // scrub: 1,
        },
        opacity: 0,
        y: 50,
        scale: 0.97,
        stagger: 0.2,
        duration: 2,
      });

      // BUTTONS (soft pop)
      gsap.from(".event-button", {
        scrollTrigger: {
          trigger: ".section-event",
          start: "top 65%",
          // scrub: 1,
        },
        opacity: 0,
        scale: 0.8,
        y: 10,
        stagger: 0.1,
        ease: "back.out(1.4)",
        duration: 1.2,
      });

      // FOOTER TEXT
      gsap.from(".footer", {
        scrollTrigger: {
          trigger: ".section-event",
          start: "top 60%",
          // scrub: 1,
        },
        opacity: 0,
        y: 30,
        duration: 1.5,
      });
    });

    return () => ctx.revert();
  }, []);

  return (
    <Container>
      <div className="section-event min-h-screen bg-white relative overflow-hidden text-center">
        {/* FLOWERS */}
        <img
          id="flower-1"
          src={Flower1}
          className="w-[317px] rotate-[180deg] absolute translate-y-[-120px]"
        />
        <img
          id="flower-2"
          src={Flower1}
          className="w-[317px] absolute right-[-50px] translate-y-[500px]"
        />

        <div className="absolute inset-0 bg-white/70 z-0" />

        <div className="relative z-10 px-10 py-14">
          {/* HEADER */}
          <div className="event-header flex justify-center mb-8">
            <img className="w-[40%]" src={IconColor} />
          </div>

          {/* TITLE */}
          <p className="title font-alex text-4xl text-[#B6A893] font-extralight">
            Wedding Date
          </p>

          <p className="title font-body font-bold text-brown text-2xl mb-8">
            6 JUNI 2026
          </p>

          {/* COUNTDOWN */}
          <div className="flex justify-center gap-1 mb-14">
            <TimeBox label="D" value={timeLeft.days} />
            <TimeBox label="H" value={timeLeft.hours} />
            <TimeBox label="M" value={timeLeft.minutes} />
            <TimeBox label="S" value={timeLeft.seconds} />
          </div>

          {/* RESEPSI */}
          <div className="event-block mb-24">
            <p className="title font-body font-bold text-brown text-2xl mb-5">
              RESEPSI PERNIKAHAN
            </p>

            <p className="title font-content text-md font-medium text-brown">
              PUKUL 12.30 - 14.30 WIB
            </p>

            <p className="title font-content text-xs text-brown ">
              GRAHA LILA SEMESTA
            </p>

            <p className="title font-content text-xs text-brown mb-10">
              JOHO, SUMBEREJO, KEC. NGASEM, KABUPATEN KEDIRI
            </p>

            <button className="event-button bg-brown-dark px-14 py-2 text-white text-xs">
              LOKASI
            </button>
          </div>

          {/* PEMBERKATAN */}
          <div className="event-block mb-20">
            <p className="title font-body font-bold text-brown text-2xl mb-5">
              PEMBERKATAN
            </p>

            <p className="title font-content text-md font-medium text-brown">
              PUKUL 08.00 - 10.00 WIB
            </p>

            <p className="title font-content text-xs text-brown ">
              GKJW KEDIRI
            </p>

            <p className="title font-content text-xs text-brown mb-10">
              Jl. DIPONEGORO NO. 15 KOTA KEDIRI
            </p>

            <button className="event-button bg-brown-dark px-14 py-2 text-white text-xs">
              LOKASI
            </button>
          </div>

          {/* FOOTER */}
          <p className="footer font-content text-xs text-brown">
            ATAS KEHADIRAN DAN DOA RESTU KAMI MENGUCAPKAN TERIMA KASIH
          </p>
        </div>
      </div>
    </Container>
  );
}

function TimeBox({ label, value }) {
  return (
    <div className="countdown-box p-4 w-14 font-body flex items-center justify-center text-brown">
      <div className="mr-[2px]">{value.toString().padStart(2, "0")}</div>
      <div>{label}</div>
    </div>
  );
}

export default Event;
