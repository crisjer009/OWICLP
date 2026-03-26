<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal System</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;600;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --scep-base: #83cd6a;
            --scep-deep: #204a20;
            --scep-glow: rgba(131, 205, 106, 0.4);
            
            --war-base: #8bacf6;
            --war-deep: #627bc5;
            --war-glow: rgba(139, 172, 246, 0.4);

            --glass: rgba(255, 255, 255, 0.03);
            --border: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

       body {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #f2f3f580; 
    background-image: 
        radial-gradient(at 0% 0%, rgba(131, 205, 106, 0.64) 0px, transparent 50%),
        radial-gradient(at 100% 100%, rgba(139, 173, 246, 0.62) 0px, transparent 50%),
        radial-gradient(at 50% 50%, rgba(32, 74, 32, 0.51) 0px, transparent 80%);
    color: #0a0a0a;
    overflow-x: hidden;
    position: relative;
    animation: backgroundPulse 12s ease-in-out infinite alternate;
}

body::before {
    content: "";
    position: absolute;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, var(--scep-glow) 0%, transparent 70%);
    top: -200px;
    left: -100px;
    z-index: -1;
    filter: blur(80px);
    opacity: 0.4;
}

body::after {
    content: "";
    position: absolute;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, var(--war-glow) 0%, transparent 70%);
    bottom: -150px;
    right: -50px;
    z-index: -1;
    filter: blur(100px);
    opacity: 0.4;
}
        body::before { top: -10%; left: -10%; background: var(--scep-base); }
        body::after { bottom: -10%; right: -10%; background: var(--war-base); }

        .container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1100px;
            padding: 20px;
        }

        header {
            text-align: left;
            margin-bottom: 50px;
            border-left: 4px solid #050505;
            padding-left: 25px;
        }

        header h1 {
            font-size: 3.5rem;
            font-weight: 900;
            letter-spacing: -2px;
            line-height: 1;
        }

        header p {
            color: #080808;
            margin-top: 10px;
            font-size: 1.1rem;
        }

        .portal-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
        }

          .portal-card {
          position: relative;
          background: rgba(255, 255, 255, 0.4); 
         backdrop-filter: blur(25px) saturate(160%);
         -webkit-backdrop-filter: blur(25px) saturate(160%);
         border: 1px solid rgba(255, 255, 255, 0.6);
         border-radius: 40px;
         padding: 50px;
         overflow: hidden;
         transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
         cursor: pointer;
        box-shadow:  inset 0 0 20px rgba(255, 255, 255, 0.3),
        0 15px 35px rgba(0, 0, 0, 0.05);
        }

        .portal-card:hover {
          transform: translateY(-10px) scale(1.01);
          background: rgba(255, 255, 255, 0.55);
         border-color: var(--accent);
         box-shadow: 
        0 30px 60px rgba(0, 0, 0, 0.1),
        0 0 15px var(--accent);
}
 .portal-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.5s ease;
    pointer-events: none;
}

.portal-card:hover::before {
    opacity: 1;
}
        .portal-card::after {
    content: '';
    position: absolute;
    top: -20px; 
    right: -20px;
    width: 120px;
    height: 120px;
    background: var(--accent);
    filter: blur(40px);
    opacity: 0.3;
    transition: 0.6s ease;
}

.portal-card:hover::after {
    width: 180px;
    height: 180px;
    opacity: 0.6;
    filter: blur(50px);
}

        .card-owi { --accent: var(--scep-base); }
        .card-dts { --accent: var(--war-base); }

        .system-label {
    display: inline-block;
    padding: 6px 15px;
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    margin-bottom: 25px;
    background: rgba(0, 0, 0, 0.8); 
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

        .card-owi .system-label { color: var(--scep-base); }
        .card-dts .system-label { color: var(--war-base); }

        h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            font-weight: 600;
            color: #050505;
        }

        .description {
          color: #333; 
         font-weight: 400; 
        line-height: 1.6;
         margin-bottom: 40px;
         }

        .action-area {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .btn-portal {
            text-decoration: none;
            color: #050505;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }

        .btn-portal span {
            width: 45px;
            height: 45px;
            border: 1px solid var(--border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .portal-card:hover .btn-portal span {
            background: #fff;
            color: #000;
            transform: translateX(10px);
        }

       /* --- RESPONSIVE ENGINE --- */

/* Tablet Optimization (iPad, Surface, etc.) */
@media (max-width: 1024px) {
    .container {
        max-width: 90%;
        padding: 40px 0;
    }

    header h1 {
        font-size: 3rem;
    }

    .portal-grid {
        /* Forces 2 columns on tablets, but 1 column on smaller tablets */
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); 
        gap: 20px;
    }

    .portal-card {
        padding: 40px; /* Slightly tighter padding */
    }

    h2 {
        font-size: 2rem;
    }
}

/* Mobile Optimization (Phones) */
@media (max-width: 768px) {
    body {
        /* Allows the page to scroll if the cards are tall */
        overflow-y: auto; 
        align-items: flex-start; /* Prevents cards from being cut off at the top */
        padding: 40px 0;
    }

    .container {
        width: 100%;
        padding: 20px;
    }

    header {
        margin-bottom: 30px;
        padding-left: 15px;
    }

    header h1 {
        font-size: 2.2rem;
        letter-spacing: -1px;
    }

    header p {
        font-size: 0.9rem;
    }

    .portal-grid {
        grid-template-columns: 1fr; /* Force single column stack */
        gap: 25px;
    }

    .portal-card {
        padding: 30px;
        border-radius: 30px; /* Softer corners for small screens */
    }

    /* Stop the cards from scaling up on touch to prevent weird zoom issues */
    .portal-card:hover {
        transform: translateY(-5px); 
    }

    h2 {
        font-size: 1.75rem;
        margin-bottom: 10px;
    }

    .description {
        font-size: 0.95rem;
        margin-bottom: 30px;
        line-height: 1.5;
    }

    /* Make the buttons more "thumb-friendly" */
    .btn-portal {
        width: 100%;
        justify-content: space-between;
        padding: 15px 20px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 15px;
    }

    .btn-portal span {
        width: 35px;
        height: 35px;
    }
    
    /* Reposition the glowing background circles for mobile */
    body::before { width: 300px; height: 300px; top: -50px; left: -50px; }
    body::after { width: 300px; height: 300px; bottom: -50px; right: -50px; }
}

/* Landscape mode for phones */
@media (max-height: 500px) and (orientation: landscape) {
    body {
        align-items: flex-start;
        overflow-y: auto;
    }
    .portal-grid {
        grid-template-columns: 1fr 1fr;
    }
}
    </style>
</head>
<body>

<div class="container">
    <header>
        <p>OFFICEWAREHOUSE</p>
        <h1>PORTALS </h1>
    </header>

    <div class="portal-grid">
        <div class="portal-card card-owi">
            <div class="system-label">Digital Tracking</div>
            <h2>Data Tracking<br>System</h2>
            <p class="description">Track and manage data in real time with an organized platform that ensures efficient monitoring and secure record keeping.</p>
            <div class="action-area">
                <a href="?system=puregold" class="btn-portal">
                    Enter Portal <span>&rarr;</span>
                </a>
            </div>
        </div>

        <div class="portal-card card-dts">
            <div class="system-label">Operational Intelligence</div>
            <h2>OWI<br>Helpdesk</h2>
            <p class="description">A support system designed to handle user concerns, report technical issues, and provide timely solutions.</p>
            <div class="action-area">
                <a href="?system=fishermall" class="btn-portal">
                    Enter Portal <span>&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>