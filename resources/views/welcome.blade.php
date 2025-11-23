@extends('layouts.app')

@section('title', 'Welcome to SkillHub')

@section('content')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }
    
    .animate-fade-in-up {
        animation: fadeInUp 0.8s ease-out;
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
</style>

<section class="gradient-bg min-h-screen flex items-center justify-center relative overflow-hidden -mx-4 sm:-mx-6 lg:-mx-8 -mt-8">
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute w-96 h-96 bg-white opacity-5 rounded-full -top-48 -left-48 animate-float"></div>
        <div class="absolute w-96 h-96 bg-white opacity-5 rounded-full -bottom-48 -right-48 animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute w-64 h-64 bg-white opacity-5 rounded-full top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 animate-float" style="animation-delay: 2s;"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center animate-fade-in-up">
            <div class="mb-8 flex justify-center">
                <div class="w-24 h-24 bg-white rounded-2xl shadow-2xl flex items-center justify-center transform hover:scale-110 transition-transform duration-300">
                    <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            </div>
            
            <!-- Main Heading -->
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6">
                Welcome to <span class="text-yellow-300">SkillHub</span>
            </h1>
            
            
        
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('participants.index') }}" class="group bg-white text-indigo-600 px-8 py-4 rounded-xl font-semibold text-lg shadow-2xl hover:shadow-3xl transform hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
                    Get Started
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
            
        </div>
    </div>
</section>
@endsection