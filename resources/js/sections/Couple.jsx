import React from "react";
import { useGSAP } from "@gsap/react";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

import Container from "../layout/Container";
import { Flower1, Bride, Groom, IconWhite } from "../assets/images";

gsap.registerPlugin(ScrollTrigger);

function Couple() {
    useGSAP(() => {
        const ctx = gsap.context(() => {
            // FLOWER
            gsap.from("#flower-3, #flower-4", {
                scrollTrigger: {
                    trigger: ".section-couple",
                    start: "top 85%",
                    // scrub: 1,
                },
                opacity: 0,
                y: 60,
                scale: 0.85,
                duration: 2,
                stagger: 0.2,
            });

            // INTRO TEXT
            gsap.from(".intro-text", {
                scrollTrigger: {
                    trigger: ".section-couple",
                    start: "top 80%",
                    // scrub: 1,
                },
                opacity: 0,
                y: 30,

                duration: 2,
                ease: "power2.out",
            });

            // NAMES
            gsap.from(".names", {
                scrollTrigger: {
                    trigger: ".section-couple",
                    start: "top 75%",
                    // scrub: 1,
                },
                opacity: 0,
                y: 40,
                scale: 0.98,

                duration: 2,
                stagger: 0.15,
                ease: "power3.out",
            });

            // AMPERSAND
            gsap.from(".ampersand", {
                scrollTrigger: {
                    trigger: ".section-couple",
                    start: "top 70%",
                    // scrub: 1,
                },
                opacity: 0,
                scale: 0.3,
                rotation: -20,
                duration: 1.8,
                ease: "back.out(1.7)",
            });

            // PHOTO LEFT
            gsap.from(".photo-left", {
                scrollTrigger: {
                    trigger: ".section-couple",
                    start: "top 65%",
                    // scrub: 1,
                },
                opacity: 0,
                x: -120,
                scale: 0.9,

                duration: 2,
                ease: "power3.out",
            });

            // PHOTO RIGHT
            gsap.from(".photo-right", {
                scrollTrigger: {
                    trigger: ".section-couple",
                    start: "top 65%",
                    // scrub: 1,
                },
                opacity: 0,
                x: 120,
                scale: 0.9,

                duration: 2,
                ease: "power3.out",
            });
        });

        return () => ctx.revert();
    }, []);

    return (
        <Container>
            <div className="section-couple min-h-screen bg-cover bg-center relative overflow-hidden bg-white">
                {/* FLOWERS */}
                <img
                    id="flower-3"
                    src={Flower1}
                    className=" w-[317px] rotate-[180deg] translate-y-[-120px] absolute"
                />
                <img
                    id="flower-4"
                    src={Flower1}
                    className=" w-[317px] translate-y-[500px] right-[-50px] absolute"
                />

                <div className="absolute inset-0 bg-primary/90 z-0" />

                <div className="relative z-10 px-10 py-14">
                    {/* LOGO */}
                    <div className="flex justify-center mb-8">
                        <img className="w-[40%] logo" src={IconWhite} />
                    </div>

                    {/* INTRO */}
                    <p className="intro-text font-content font-light text-xs text-white text-center mb-9">
                        MERUPAKAN SUATU KEHORMATAN BAGI KAMI APABILA BAPAK / IBU
                        / SAUDARA / I BERKENAN HADIR UNTUK MEMBERIKAN DOA RESTU
                        PADA RESEPSI PERNIKAHAN PUTRA-PUTRI KAMI
                    </p>

                    {/* NAMES */}
                    <p className="names text-3xl font-bold font-body text-white text-center mb-5 font-cormorant ">
                        Andreas Kurnia <br /> Ferdiantoro S.Kom
                    </p>

                    <p className="names font-content font-light text-xs text-white text-center">
                        PUTRA DARI <br />
                        Bpk. Ir. Johannes Boedijantoro <br />
                        Ibu Ferie Kusuma Kristyaningsih S.Keb Bdn
                    </p>

                    <p className="ampersand text-2xl font-bold font-body text-white text-center my-9">
                        &
                    </p>
                    <p className="names text-3xl font-bold font-cormorant text-white text-center mb-5">
                        dr. Kasilda <br /> Pasha Devanda
                    </p>

                    <p className="names font-content font-light text-xs text-white text-center mb-14">
                        PUTRI DARI <br />
                        Bpk. Dr. Antonius Gatot Subroto, Sp.N, FMIN <br />
                        Ibu Ida Erviyani (Almh)
                    </p>

                    {/* COUPLE */}
                    <div className="flex items-center justify-center gap-10 mb-3">
                        <div className="photo-left w-36 h-36 overflow-hidden rounded-lg">
                            <img
                                src={Groom}
                                className="w-full h-full object-cover scale-150"
                            />
                        </div>

                        <p className="names text-white font-alex text-3xl">
                            Andreas <br /> Kurnia <br /> Ferdiantoro
                        </p>
                    </div>

                    <div className="flex items-center justify-center gap-10">
                        <p className="names text-white font-alex text-3xl text-right">
                            Kasilda <br /> Pasha <br /> Devanda
                        </p>

                        <div className="photo-right w-36 h-36 overflow-hidden rounded-lg">
                            <img
                                src={Bride}
                                className="w-full h-full object-cover transform scale-x-[-1]"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </Container>
    );
}

export default Couple;
