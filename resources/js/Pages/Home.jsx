import React, { useEffect, useRef } from "react";
import gsap from "gsap";
import "swiper/css";
import "swiper/css/autoplay";
import "yet-another-react-lightbox/styles.css";

import { Bg, Image10 } from "../assets/images";
import Intro from "../sections/Intro";
import Couple from "../sections/Couple";
import Event from "../sections/Event";
import Gallery from "../sections/Gallery";
import Carousel from "../sections/Carousel";
import OurStory from "../sections/OurStory";
import RSVP from "../sections/RSVP";
import Footer from "../sections/Footer";
import Gift from "../sections/Gift";
import MusicPlayer from "../sections/MusicPlayer";

function Home() {
    const titleRef = useRef(null);
    const subtitleRef = useRef(null);

    useEffect(() => {
        const tl = gsap.timeline();

        tl.from(titleRef.current, {
            y: 100,
            opacity: 0,
            duration: 1.5,
            ease: "power4.out",
        }).from(
            subtitleRef.current,
            {
                y: 50,
                opacity: 0,
                duration: 1.2,
            },
            "-=1"
        );
    }, []);

    return (
        <div>
            <div
                className="fixed inset-0 -z-20 bg-cover bg-center"
                style={{ backgroundImage: `url(${Bg})` }}
            />
            <div className="fixed inset-0 -z-10 bg-black/40" />
            <MusicPlayer />
            <Intro />
            <Couple />
            <Carousel />
            <Event />
            <OurStory />
            <Gallery />
            <Gift />
            <RSVP />
            <Footer />
        </div>
    );
}

export default Home;
