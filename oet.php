<?php
// Start of PHP file
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OET (Occupational English Test)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="img/logoulit.png">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            /* Prevent horizontal scroll */
        }

        /* Header Styling */
        header {
            position: relative;
            min-height: 80vh;
        }

        .header-bg-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .header-logo {
            max-height: 100px;
        }

        .header-content {
            min-height: 80vh;
        }

        .white-text-shadow {
            color: white;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7);
        }

        /* Back Button */
        .btn-back {
            position: absolute;
            top: 1rem;
            left: 1rem;
            z-index: 1001;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background-color: #0C470C;
            color: white;
            border-radius: 50%;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background-color: #023621;
            transform: scale(1.1);
        }

        .btn-back i {
            font-size: 1.2rem;
        }

        /* Card image styling */
        .card-img-responsive {
            height: 250px;
            object-fit: cover;
        }

        /* Custom Accordion Styling */
        .accordion-button:focus {
            box-shadow: none;
            border-color: rgba(0, 0, 0, .10);
        }

        .accordion-button:not(.collapsed) {
            background-color: #e7f1ff;
            color: #0c4128;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #3BA43B, #0C470C);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #45b945, #0a3a0a);
        }

        /* --- Responsive Media Queries --- */
        @media (max-width: 768px) {
            h1.display-4 {
                font-size: 2.2rem;
                /* Adjusted for better mobile view */
            }

            h2.display-5 {
                font-size: 1.8rem;
            }

            p.lead {
                font-size: 1rem;
            }

            .btn-back {
                top: 0.5rem;
                left: 0.5rem;
                width: 40px;
                height: 40px;
            }

            .header-logo {
                max-height: 60px;
                /* Smaller logo on mobile */
            }

            .card-img-responsive {
                height: 200px;
                /* Smaller card image height on mobile */
            }
        }
    </style>
</head>

<body>
    <a href="index.html" class="btn-back" aria-label="Go Back">
        <i class="bi-arrow-left-short"></i>
    </a>

    <header>
        <img src="img/OET.jpg" class="header-bg-img" alt="Healthcare professionals in a discussion">
        <div class="position-absolute top-0 end-0 p-3">
            <img src="img/oetlogo.svg" class="img-fluid header-logo" alt="OET Logo">
        </div>
        <div class="container d-flex flex-column justify-content-end header-content">
            <div class="text-start mb-5 pb-4">
                <h1 class="display-4 white-text-shadow">Occupational English Test (OET)</h1>
                <p class="lead mt-3 white-text-shadow">
                    OET is a specialized English test for healthcare professionals that assesses clinical
                    communication skills for registration, employment, or migration.
                </p>
                <a href="https://oet.com/test/book-a-test?location=Lipa%2C%20Batangas%2C%20Calabarzon%2C%20Philippines&latLng=13.941876%2C121.1644198"
                    class="btn px-4 py-2 text-white" style="background-color: #0C470C;">Book Now</a>
            </div>
        </div>
    </header>

    <main>
        <section id="about" class="py-5">
            <div class="container text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="display-5 fw-bold">About Us</h2>
                        <p class="mt-4 fs-5">
                            OET stands for the Occupational English Test. Unlike general English tests, OET is developed
                            exclusively
                            for healthcare professionals—including doctors, nurses, dentists, pharmacists, and
                            allied health workers.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="test-format" class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold">Test Format</h2>
                </div>
                <div class="row g-4">
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-white rounded-4 text-center h-100 p-4 shadow-sm">
                            <i class="bi bi-headphones display-3" style="color: #0C470C;"></i>
                            <h3 class="fs-4 fw-bold mt-3">Listening</h3>
                            <p>50 minutes, with healthcare-related interactions.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-white rounded-4 text-center h-100 p-4 shadow-sm">
                            <i class="bi bi-pencil-square display-3" style="color: #0C470C;"></i>
                            <h3 class="fs-4 fw-bold mt-3">Writing</h3>
                            <p>60 minutes, usually a referral letter or clinical writing task.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-white rounded-4 text-center h-100 p-4 shadow-sm">
                            <i class="bi bi-book-half display-3" style="color: #0C470C;"></i>
                            <h3 class="fs-4 fw-bold mt-3">Reading</h3>
                            <p>60 minutes, with texts from healthcare documents.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="bg-white rounded-4 text-center h-100 p-4 shadow-sm">
                            <i class="bi bi-mic display-3" style="color: #0C470C;"></i>
                            <h3 class="fs-4 fw-bold mt-3">Speaking</h3>
                            <p>20 minutes, in a one-to-one clinical role-play.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <h2 class="text-center mb-5 display-5 fw-bold">Why should you choose OET?</h2>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="img/oet1.jpg" class="card-img-top card-img-responsive"
                                alt="Healthcare professional studying">
                            <div class="card-body d-flex flex-column p-4">
                                <h4 class="card-title fw-bold">Specifically Designed for Healthcare Professionals</h4>
                                <p class="card-text">The OET is created exclusively for the healthcare sector. All test
                                    materials use a familiar clinical context, making it more intuitive for doctors,
                                    nurses, and other health professionals.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="img/ielts_p2.jpg" class="card-img-top card-img-responsive"
                                alt="Doctor consulting with a patient">
                            <div class="card-body d-flex flex-column p-4">
                                <h4 class="card-title fw-bold">Simulating Real-World Clinical Scenarios</h4>
                                <p class="card-text">OET assesses language skills using tasks you perform daily. For
                                    example, you will write a referral letter or role-play a patient consultation. This
                                    tests essential communication skills for safe patient care.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="img/ielts_p3.jpg" class="card-img-top card-img-responsive"
                                alt="Group of diverse healthcare workers">
                            <div class="card-body d-flex flex-column p-4">
                                <h4 class="card-title fw-bold">Fostering Confidence Through Familiarity</h4>
                                <p class="card-text">The test’s focus on medical topics allows you to use your existing
                                    professional knowledge. This familiarity builds confidence and helps you accurately
                                    demonstrate your language abilities.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="img/ielts_p4.jpg" class="card-img-top card-img-responsive"
                                alt="World map with connection lines">
                            <div class="card-body d-flex flex-column p-4">
                                <h4 class="card-title fw-bold">Globally Recognized and Trusted</h4>
                                <p class="card-text">A successful OET result is a powerful asset for your career. It is
                                    widely accepted by regulators in countries like the UK, USA, Australia, and Canada
                                    for registration, employment, and visas.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="img/oet5.jpg" class="card-img-top card-img-responsive"
                                alt="Person writing on a clipboard">
                            <div class="card-body d-flex flex-column p-4">
                                <h4 class="card-title fw-bold">A Pathway to Professional Development</h4>
                                <p class="card-text">Preparing for the OET is practical job training. The skills you
                                    develop, such as writing medical correspondence and understanding consultations, are
                                    directly transferable to your work.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="img/oet6.jpg" class="card-img-top card-img-responsive"
                                alt="A doctor holding a stethoscope">
                            <div class="card-body d-flex flex-column p-4">
                                <h4 class="card-title fw-bold">The Clear Choice for a Healthcare Career</h4>
                                <p class="card-text">OET is more than a language test; it validates your ability to
                                    communicate in a clinical setting. Its focus on relevant skills and global
                                    recognition makes it the superior choice.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-light">
            <div class="container my-md-4">
                <div class="text-center mb-5">
                    <h2 class="fw-bold display-5">How does OET work?</h2>
                    <p class="text-center mx-auto fs-5 my-4 col-lg-9">
                        The Occupational English Test (OET) is a language proficiency exam for healthcare professionals,
                        evaluating English skills in a clinical context through four sub-tests: Listening, Reading,
                        Writing, and Speaking.
                    </p>
                </div>

                <div class="row g-4 justify-content-center mb-5 pb-4">
                    <div class="col-lg-5 col-md-8">
                        <div class="bg-white p-4 p-md-5 rounded-4 text-center h-100">
                            <h3 class="fw-bold fs-4 mb-3">OET Academic</h3>
                            <p class="mb-0">This test can help you secure university acceptance, student visas, and
                                prove your English ability to professional organisations.</p>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-8">
                        <div class="bg-white p-4 p-md-5 rounded-4 text-center h-100">
                            <h3 class="fw-bold fs-4 mb-3">OET General Training</h3>
                            <p class="mb-0">This test assesses your workplace English skills and helps demonstrate your
                                level when applying to English-speaking companies.</p>
                        </div>
                    </div>
                </div>

                <div class="text-center mb-5">
                    <h2 class="fw-bold">Frequently Asked Questions</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item mb-2 border-0 rounded-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-3 rounded-3" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false"
                                        aria-controls="collapseOne">
                                        Who accepts OET scores?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        OET scores are recognized by regulatory bodies and healthcare employers in
                                        Australia, New Zealand, the United Kingdom, and several other countries for both
                                        professional registration and employment purposes.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-2 border-0 rounded-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-3 rounded-3" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo">
                                        How is OET scored?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Each sub-test is graded on a letter scale from A (highest) to E (lowest). Most
                                        regulatory bodies require a minimum grade of B in every sub-test.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-2 border-0 rounded-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-3 rounded-3" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        What is the test format and duration?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        OET comprises four sub-tests:
                                        <ul>
                                            <li>Listening: ~50 minutes</li>
                                            <li>Reading: 60 minutes</li>
                                            <li>Writing: 60 minutes</li>
                                            <li>Speaking: ~20 minutes</li>
                                        </ul>
                                        Total test time is approximately 3 hours, with each section featuring
                                        healthcare-specific tasks.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-2 border-0 rounded-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-3 rounded-3" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                        How do I register for the OET exam?
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Registration is completed online via the official OET website. Simply create an
                                        account, fill in your details, select your test module, date, and centre, upload
                                        your ID, and make the payment.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-2 border-0 rounded-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-3 rounded-3" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false"
                                        aria-controls="collapseFive">
                                        What should I bring on test day?
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        You must bring your original identification document (passport or national ID)
                                        used during registration along with your test confirmation. Check with your
                                        centre for any additional allowed items.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-2 border-0 rounded-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-3 rounded-3" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix">
                                        Can I retake the OET exam if I don’t achieve my desired grade?
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Yes, there is no limit to the number of times you can take the OET exam. You can
                                        re-register for a new test date at any time.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-2 border-0 rounded-3">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed p-3 rounded-3" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false"
                                        aria-controls="collapseSeven">
                                        What if I need to reschedule or cancel my test?
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse"
                                    data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Rescheduling or cancellation policies vary by centre. Typically, you must
                                        request changes several weeks in advance and may incur an administrative fee if
                                        done close to the test date. Contact your test centre for specific guidelines.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

    <script>   // SCRIPT TO FETCH AND LOAD FOOTER
        document.addEventListener("DOMContentLoaded", function () {
            const placeholder = document.getElementById("footer-placeholder");

            // Since this file is in a subfolder, the path is relative to the root
            fetch('footer.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status} - Could not find footer-fragment.php`);
                    }
                    return response.text();
                })
                .then(data => {
                    const parser = new DOMParser();
                    const footerDoc = parser.parseFromString(data, 'text/html');

                    footerDoc.querySelectorAll('style').forEach(style => document.head.appendChild(style));

                    const bodyContent = footerDoc.body.firstElementChild;
                    if (bodyContent) {
                        placeholder.appendChild(bodyContent);
                    }

                    const scriptTag = footerDoc.querySelector('script');
                    if (scriptTag) {
                        const newScript = document.createElement('script');
                        newScript.textContent = scriptTag.textContent;
                        document.body.appendChild(newScript);
                    }
                })
                .catch(error => {
                    console.error("Footer loading failed:", error);
                    if (placeholder) {
                        placeholder.innerHTML = `<p style="text-align:center; color:red; padding: 20px;"><b>Error:</b> Footer could not be loaded. Please check the console for details.</p>`;
                    }
                });
        });</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>