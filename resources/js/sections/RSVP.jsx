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
import { useForm } from "@inertiajs/react";

gsap.registerPlugin(ScrollTrigger);

const rsvp_status = [
    {
        code: "hadir",
        name: "Hadir",
    },
    {
        code: "tidak_hadir",
        name: "Tidak Hadir",
    },
];

const sides = [
    {
        code: "groom",
        name: "Groom",
    },
    {
        code: "bride",
        name: "Bride",
    },
];

function RSVP({ guest, wishes }) {
    const [successOpen, setSuccessOpen] = useState(false);

    const successRef = useRef(null);
    const successBackdropRef = useRef(null);
    const previewRef = useRef(null);
    const { data, setData, post, processing, errors } = useForm({
        unique_code: guest?.unique_code,
        name: guest?.name,
        rsvp_status: guest?.rsvp_status,
        side: guest?.side,
        message: guest?.message,
        gift_image: "",
    });
    const [preview, setPreview] = useState(
        guest?.gift_image_url ? `${guest.gift_image_url}` : null
    );

    function handleChange(e) {
        setData(e.target.id, e.target.value);
    }

    const handleSubmit = (e) => {
        e.preventDefault();
        post("/rsvp", {
            preserveScroll: true,
            preserveState: true, // biar form tidak reset otomatis
            onSuccess: () => {
                setSuccessOpen(true);

                // setData({
                //     name: "",
                //     rsvp_status: "",
                //     side: "",
                //     message: "",
                //     gift_image: "",
                // });
            },
        });
    };
    const animateModal = (open, modal, backdrop) => {
        if (!modal.current || !backdrop.current) return;

        if (open) {
            gsap.to(backdrop.current, {
                opacity: 1,
                pointerEvents: "auto",
                duration: 0.25,
            });

            gsap.fromTo(
                modal.current,
                { opacity: 0, scale: 0.9, y: 30 },
                {
                    opacity: 1,
                    scale: 1,
                    y: 0,
                    duration: 0.35,
                    ease: "power3.out",
                }
            );
        } else {
            gsap.to(modal.current, {
                opacity: 0,
                scale: 0.9,
                y: 20,
                duration: 0.2,
            });

            gsap.to(backdrop.current, {
                opacity: 0,
                pointerEvents: "none",
                duration: 0.2,
            });
        }
    };

    // 🎞️ SCROLL ANIMATION
    useLayoutEffect(() => {
        const ctx = gsap.context(() => {
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

    useEffect(() => {
        animateModal(successOpen, successRef, successBackdropRef);
    }, [successOpen]);

    useEffect(() => {
        if (successOpen) {
            const timer = setTimeout(() => {
                setSuccessOpen(false);
            }, 2500);

            return () => clearTimeout(timer);
        }
    }, [successOpen]);

    const handleImageUpload = async (event) => {
        const imageFile = event.target.files[0];
        if (!imageFile) return;

        let finalFile = imageFile;

        if (imageFile.size >= 2000000) {
            const options = {
                maxSizeMB: 1,
                maxWidthOrHeight: 500,
                useWebWorker: true,
            };

            try {
                const compressedBlob = await imageCompression(
                    imageFile,
                    options
                );
                finalFile = new File([compressedBlob], imageFile.name, {
                    type: compressedBlob.type,
                });
            } catch (error) {
                console.error(error);
            }
        }

        // set ke inertia form
        setData("gift_image", finalFile);

        // bikin preview
        const previewUrl = URL.createObjectURL(finalFile);
        setPreview(previewUrl);
    };

    useEffect(() => {
        if (guest?.gift_image_url) {
            setPreview(`${guest.gift_image_url}`);
        }
    }, [guest]);

    useEffect(() => {
        if (preview && previewRef.current) {
            gsap.fromTo(
                previewRef.current,
                { opacity: 0, scale: 0.95, y: 20 },
                {
                    opacity: 1,
                    scale: 1,
                    y: 0,
                    duration: 0.5,
                    ease: "power3.out",
                }
            );
        }
    }, [preview]);

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
                            autoplay={{
                                delay: 3000,
                                disableOnInteraction: false,
                            }}
                            loop
                            modules={[Autoplay, EffectFade]}
                        >
                            {wishes.map((text, i) => (
                                <SwiperSlide key={i}>
                                    <div className="text-center text-brown">
                                        <p className="font-dancing text-sm px-6">
                                            {text.message}
                                        </p>
                                        <p className="font-dancing text-xl mt-2">
                                            {text.name}
                                        </p>
                                    </div>
                                </SwiperSlide>
                            ))}
                        </Swiper>
                    </div>

                    {/* RSVP TITLE */}
                    <p className="rsvp-title font-body font-bold text-brown text-2xl mb-5">
                        RSVP
                    </p>
                    <form onSubmit={handleSubmit}>
                        {/* FORM */}
                        <div className="rsvp-form flex flex-col text-brown font-content font-light">
                            <div className="rsvp-field flex flex-col items-start mb-3">
                                <label className="text-xs mb-2">NAMA</label>
                                <input
                                    disabled={guest && true}
                                    required
                                    onChange={handleChange}
                                    value={guest?.name}
                                    name="name"
                                    id="name"
                                    className={`border border-brown p-2 w-full ${
                                        guest && "bg-gray-200"
                                    }`}
                                />
                            </div>

                            <div className="rsvp-field flex flex-col items-start mb-3">
                                <label className="text-xs mb-2">
                                    KEHADIRAN
                                </label>
                                <select
                                    required
                                    onChange={handleChange}
                                    id="rsvp_status"
                                    className="border border-brown p-2 w-full"
                                >
                                    <option value={"pending"}>
                                        -- Status Kehadiran --
                                    </option>

                                    {rsvp_status.map((item) => {
                                        let status =
                                            guest.rsvp_status == item.code &&
                                            "selected";
                                        return (
                                            <option
                                                selected={status}
                                                value={item.code}
                                            >
                                                {item.name}
                                            </option>
                                        );
                                    })}
                                </select>
                            </div>
                            <div className="rsvp-field flex flex-col items-start mb-3">
                                <label className="text-xs mb-2">SIDE</label>
                                <select
                                    required
                                    onChange={handleChange}
                                    id="side"
                                    className="border border-brown p-2 w-full"
                                >
                                    <option>-- Side --</option>
                                    {sides.map((item) => {
                                        let side =
                                            guest.side == item.code &&
                                            "selected";
                                        return (
                                            <option
                                                selected={side}
                                                value={item.code}
                                            >
                                                {item.name}
                                            </option>
                                        );
                                    })}
                                </select>
                            </div>
                            <div className="rsvp-field flex flex-col items-start mb-3">
                                <label className="text-xs mb-2">GIFT</label>
                                <input
                                    name="gift_image"
                                    onChange={handleImageUpload}
                                    type="file"
                                    className="border border-brown p-2 w-full"
                                />
                            </div>
                            {preview && (
                                <div
                                    ref={previewRef}
                                    className="my-2 w-full overflow-hidden rounded-lg relative group"
                                >
                                    <img
                                        src={preview}
                                        alt="Preview Gift"
                                        className="w-full h-52 object-cover transition-transform duration-500 group-hover:scale-105"
                                    />

                                    <div className="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center text-white text-xs">
                                        Preview Gift
                                    </div>
                                </div>
                            )}

                            <div className="rsvp-field flex flex-col items-start mb-6">
                                <label className="text-xs mb-2">UCAPAN</label>
                                <textarea
                                    onChange={handleChange}
                                    id="message"
                                    className="border border-brown p-2 w-full"
                                >
                                    {guest?.message}
                                </textarea>
                            </div>

                            <button
                                type="submit"
                                className="rsvp-button bg-brown-dark px-14 py-2 text-white text-xs"
                            >
                                SUBMIT
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div
                ref={successBackdropRef}
                className="fixed inset-0 bg-black/50 opacity-0 pointer-events-none flex items-center justify-center z-30"
            >
                <div
                    ref={successRef}
                    className="bg-white p-6 rounded-lg shadow-lg opacity-0 w-[85%] text-center"
                >
                    <p className="rsvp-title font-body font-bold text-brown text-2xl mb-5">
                        RSVP BERHASIL
                    </p>

                    <p className="font-content text-xs text-gray-600 mb-4">
                        Terima kasih sudah mengisi RSVP
                    </p>

                    <button
                        onClick={() => setSuccessOpen(false)}
                        className="bg-brown-dark text-white px-6 py-2 text-xs"
                    >
                        OK
                    </button>
                </div>
            </div>
        </Container>
    );
}

export default RSVP;
