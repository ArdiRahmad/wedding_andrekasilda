import React from "react";
import { Autoplay } from "swiper/modules";
import { Swiper, SwiperSlide } from "swiper/react";
import {
  Bride,
  Groom,
  Image1,
  Image10,
  Image2,
  Image3,
  Image4,
  Image5,
  Image6,
  Image7,
  Image8,
  Image9,
} from "../assets/images";
import Container from "../layout/Container";

function Carousel() {
  const images = [
    Image2,
    Image3,
    Image4,
    Image5,
    Image6,
    Image7,
    Image8,
    Image9,
    Image10,
  ];
  return (
    <div className="relative ">
      <div className="flex justify-center items-center  ">
        <div className="w-full max-w-lg   backdrop-blur-md shadow-xl overflow-hidden ">
          <Swiper
            modules={[Autoplay]}
            slidesPerView={2.5}
            loop={true}
            speed={10000} // durasi geser (semakin besar = semakin halus)
            autoplay={{
              delay: 0, // penting: tanpa jeda
              disableOnInteraction: true,
            }}
            allowTouchMove={false} // optional: biar tidak bisa di-drag
          >
            {images.map((el, index) => {
              return (
                <SwiperSlide>
                  <img src={el} alt={index} />
                </SwiperSlide>
              );
            })}
          </Swiper>
        </div>
      </div>
    </div>
  );
}

export default Carousel;
