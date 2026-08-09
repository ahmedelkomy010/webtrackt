<script setup>
import { onMounted } from 'vue';
import { fetchContent } from './composables/useContent';
import TopTicker from './components/TopTicker.vue';
import Navbar from './components/Navbar.vue';
import Hero from './components/Hero.vue';
import Services from './components/Services.vue';
import About from './components/About.vue';
import WhyUs from './components/WhyUs.vue';
import Stats from './components/Stats.vue';
import Reviews from './components/Reviews.vue';
import SuccessPartners from './components/SuccessPartners.vue';
import Works from './components/Works.vue';
import Faq from './components/Faq.vue';
import Contact from './components/Contact.vue';
import Footer from './components/Footer.vue';
import MobileBottomNav from './components/MobileBottomNav.vue';
import FloatingButtons from './components/FloatingButtons.vue';

onMounted(() => {
    fetchContent();
});
</script>

<template>
    <div class="min-h-dvh gradient-mesh app-shell">
        <TopTicker />
        <Navbar />
        <main class="flex-1 w-full">
            <Hero />
            <Services />
            <About />
            <WhyUs />
            <Stats />
            <Reviews />
            <SuccessPartners />
            <Works />
            <Faq />
            <Contact />
        </main>
        <Footer />
        <FloatingButtons />
        <MobileBottomNav />
    </div>
</template>
