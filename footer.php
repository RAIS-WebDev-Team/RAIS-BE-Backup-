<?php
// --- DATABASE CONNECTION ---
// Ensure the config file is included. It should already be available if this footer is included after the main page content.
if (!isset($pdo)) {
     require_once 'config.php';  }

// --- FETCH FOOTER CONTENT ---
$footer_content = [];
try {
    // Fetch all footer content at once and map it into an associative array
    $stmt = $pdo->query("SELECT content_key, content_value FROM footer_content");
    if ($stmt) {
        $footer_content = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }
} catch (PDOException $e) {
    error_log("Footer content fetch failed: " . $e->getMessage());
    // You can set default values here if the database fails
    $footer_content = [
        'newsletter_title' => 'Wanna Subscribe to our Newsletter?',
        'newsletter_text' => 'Get the latest updates and tips straight to your inbox.',
        'contact_email' => 'assessment@romancis.ca',
        'contact_phone' => '+63 917 185 7247 | (250) 667-0565',
        'contact_address' => 'City Sleep Inn Hotel and Events Centre, Barangay Sico, Lipa City, Batangas',
        'facebook_url' => 'https://www.facebook.com/RomansandAssociatesImmigrationServices',
        'twitter_url' => 'https://x.com/RCIS2022',
        'instagram_url' => 'https://www.instagram.com/romancis.ca/',
        'linkedin_url' => 'https://www.linkedin.com/company/roman-associates-immigration-services-ltd/',
        'tiktok_url' => 'https://www.tiktok.com/@romancanadianimmigration',
        'credits_text' => 'Roman & Associates Immigration Services LTD',
        'credits_year' => date("Y")
    ];
}
?>

<style>
    /* --- Footer Styles --- */
    .footer-wrapper {
        position: relative;
        width: 100%;
        overflow: hidden;
        transition: height 0.5s ease-in-out;
        font-family: 'Poppins', sans-serif;
    }

    #mainFooter,
    .footer-top {
        position: absolute;
        width: 100%;
        top: 0;
        left: 0;
        transition: transform 0.5s ease-in-out;
        box-sizing: border-box;
    }

    #mainFooter {
        transform: translateY(0);
        z-index: 2;
    }

    .footer-top {
        transform: translateY(100%);
        z-index: 1;
    }

    .footer-top.show {
        transform: translateY(0);
        z-index: 2;
    }

    #mainFooter.hide {
        transform: translateY(-100%);
        z-index: 1;
    }

    #mainFooter {
        background-color: #0C470C;
        color: white;
        padding: 30px 20px 15px;
    }

    .footer-container {
        display: flex;
        justify-content: space-between;
        gap: 40px;
        align-items: flex-start;
        padding: 40px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .footer-left,
    .footer-right {
        flex: 1;
        min-width: 300px;
        padding: 0 20px;
        text-align: center;
    }

    .footer-left {
        border-right: 1px solid rgba(255, 255, 255, 0.4);
    }

    .footer-right {
        padding-left: 40px;
    }

    .footer-top {
        background-image: url('https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=2070&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        color: white;
        padding: 50px 40px;
    }

    .footer-top::before {
        content: '';
        position: absolute;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.35);
        backdrop-filter: blur(3px);
    }

    .footer-links-container {
        position: relative;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        max-width: 1200px;
        margin: 0 auto;
        gap: 20px;
    }

    .footer-column h4 {
        font-size: 1.2rem;
        margin-bottom: 15px;
        color: #fff;
    }

    .footer-column ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-column ul li {
        margin-bottom: 10px;
    }

    .footer-column a {
        color: #ffffff;
        text-decoration: none;
        opacity: 0.9;
    }

    .footer-column a:hover {
        opacity: 1;
        text-decoration: underline;
    }

    .footer-toggle,
    .top-close {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 5;
    }

    .separator-btn {
        background-color: rgba(255, 255, 255, 0.2);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
        font-size: 18px;
    }

    .separator-btn:hover {
        background-color: #339933;
        transform: scale(1.08);
    }

    .subscribe-btn {
        background-color: #3BA43B;
        color: white;
        border: none;
        padding: 8px 20px;
        font-size: 14px;
        border-radius: 25px;
        margin-top: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: background 0.3s ease;
        width: fit-content;
        margin-left: auto;
        margin-right: auto;
    }

    .subscribe-btn:hover {
        background-color: #339933;
    }

    #subscription-form {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 12px;
        padding: 8px 0;
    }

    #subscription-form input {
        padding: 6px 12px;
        width: 60%;
        border-radius: 25px;
        border: none;
        outline: none;
    }

    #subscription-form button {
        background-color: #339933;
        color: white;
        border: none;
        padding: 8px 20px;
        font-size: 14px;
        border-radius: 25px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    #subscription-form button:hover {
        background-color: #2d7d2d;
    }

    .footer-socials {
        text-align: center;
        margin-top: 20px;
    }

    .footer-socials a {
        display: inline-block;
        margin: 0 10px;
        font-size: 22px;
        color: white;
        transition: color 0.3s ease, transform 0.2s ease;
    }

    .footer-socials a:hover {
        color: #3BA43B;
        transform: scale(1.15);
    }

    /* --- Subscription Notice Styles --- */
    .subscription-notice {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translate(-50%, 100px);
        padding: 12px 24px;
        border-radius: 8px;
        color: white;
        font-family: 'Poppins', sans-serif;
        z-index: 1050;
        opacity: 0;
        transition: transform 0.4s ease-in-out, opacity 0.4s ease-in-out;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .subscription-notice.show {
        transform: translate(-50%, 0);
        opacity: 1;
    }

    .subscription-notice.success {
        background-color: #0C470C; /* Green for success */
    }

    .subscription-notice.error {
        background-color: #d9534f; /* Red for error */
    }


    @media (max-width: 768px) {
        .footer-container {
            flex-direction: column;
            align-items: center;
            gap: 30px;
            padding: 30px 15px;
        }

        .footer-left {
            border-right: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
            padding-bottom: 30px;
            width: 100%;
        }

        .footer-right {
            padding-left: 20px;
            width: 100%;
        }

        .footer-links-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 25px;
        }

        .footer-column {
            border-bottom: 1px solid rgba(255, 255, 255, 0.4);
            padding-bottom: 20px;
            margin-bottom: 20px;
            width: 100%;
            text-align: center;
        }

        .footer-column:last-child {
            border-bottom: none;
        }

        #subscription-form {
            flex-direction: column;
            gap: 15px;
            width: 100%;
        }

        #subscription-form input,
        #subscription-form button {
            width: 90%;
            max-width: 300px;
        }
    }
</style>

<div class="footer-wrapper" id="footerWrapper">
    <div class="footer-top" id="footerTop">
        <button id="footerTopClose" class="separator-btn top-close" aria-label="Hide footer top">
            <i class="bi bi-chevron-down"></i>
        </button>
        <div class="footer-links-container">
            <div class="footer-column">
                <h4>Company</h4>
                <ul>
                    <li><a href="About.php">About Us</a></li>
                    <li><a href="blogs.php">Blogs</a></li>
                    <li><a href="#mainFooter" id="footerContactLink">Contacts</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Resources</h4>
                <ul>
                    <li><a href="help.php">Help Center</a></li>
                    <li><a href="guide.php">Guides</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Legal</h4>
                <ul>
                    <li><a href="terms.php">Terms</a></li>
                    <li><a href="privacy.php">Privacy</a></li>
                    <li><a href="cookies.php">Cookies</a></li>
                </ul>
            </div>
        </div>
    </div>

    <footer id="mainFooter">
        <div class="footer-toggle">
            <button id="footer-btn-up" class="separator-btn" aria-label="Show footer top">
                <i class="bi bi-chevron-up"></i>
            </button>
        </div>
        <div class="footer-container">
            <div class="footer-left">
                <h3><?php echo htmlspecialchars($footer_content['newsletter_title'] ?? 'Wanna Subscribe to our Newsletter?'); ?></h3>
                <p><?php echo htmlspecialchars($footer_content['newsletter_text'] ?? 'Get the latest updates and tips straight to your inbox.'); ?></p>
                <button onclick="showSubscriptionForm()" class="subscribe-btn">Click here</button>
                <div id="subscription-form" style="display: none;">
                    <input type="email" id="subscriberEmail" placeholder="Enter your email" required />
                    <button onclick="submitSubscription()">Subscribe</button>
                </div>
            </div>
            <div class="footer-right">
                <h3>Get In Touch</h3>
                <p>
                    <i class="bi bi-envelope-fill me-2"></i> <?php echo htmlspecialchars($footer_content['contact_email'] ?? 'assessment@romancis.ca'); ?><br />
                    <i class="bi bi-telephone-fill me-2"></i> <?php echo htmlspecialchars($footer_content['contact_phone'] ?? '+63 917 185 7247 | (250) 667-0565'); ?><br />
                    <i class="bi bi-geo-alt-fill me-2"></i> <?php echo htmlspecialchars($footer_content['contact_address'] ?? 'City Sleep Inn Hotel and Events Centre, Barangay Sico, Lipa City, Batangas'); ?>
                </p>
            </div>
        </div>
        <div class="footer-socials">
            <a href="<?php echo htmlspecialchars($footer_content['facebook_url'] ?? '#'); ?>" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="<?php echo htmlspecialchars($footer_content['twitter_url'] ?? '#'); ?>" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"/>
                </svg>
            </a>
            <a href="<?php echo htmlspecialchars($footer_content['instagram_url'] ?? '#'); ?>" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="<?php echo htmlspecialchars($footer_content['linkedin_url'] ?? '#'); ?>" target="_blank"><i class="bi bi-linkedin"></i></a>
            <a href="<?php echo htmlspecialchars($footer_content['tiktok_url'] ?? '#'); ?>" target="_blank"><i class="bi bi-tiktok"></i></a>
        </div>
         <p class="text-center mt-4 mb-0">© <?php echo htmlspecialchars($footer_content['credits_year'] ?? date("Y")); ?> <?php echo htmlspecialchars($footer_content['credits_text'] ?? 'Roman & Associates Immigration Services LTD'); ?>. All Rights Reserved.</p>
    </footer>
</div>

<script>
    // --- Footer Scripts ---
    (function() {
        function showSubscriptionForm() {
            const form = document.getElementById("subscription-form");
            const button = document.querySelector(".subscribe-btn");
            if (form && button) {
                form.style.display = "flex";
                button.style.display = "none";
            }
        }

        async function submitSubscription() {
            const emailInput = document.getElementById("subscriberEmail");
            const email = emailInput.value;
            let message = "";
            let isSuccess = false;

            if (email && /^\S+@\S+\.\S+$/.test(email)) {
                const formData = new FormData();
                formData.append('action', 'subscribe');
                formData.append('email', email);

                try {
                    const response = await fetch('api_newsletter.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();
                    
                    message = result.message;
                    isSuccess = result.success;

                    if(isSuccess) {
                        emailInput.value = "";
                        document.getElementById("subscription-form").style.display = "none";
                        document.querySelector(".subscribe-btn").style.display = "block";
                    }

                } catch (error) {
                    message = "A network error occurred. Please try again later.";
                    isSuccess = false;
                }

            } else {
                message = "Please enter a valid email address.";
                isSuccess = false;
            }
            
            showSubscriptionNotice(message, isSuccess);
        }

        function showSubscriptionNotice(message, isSuccess) {
            const notice = document.createElement('div');
            notice.textContent = message;
            notice.className = `subscription-notice ${isSuccess ? 'success' : 'error'}`;
            document.body.appendChild(notice);

            setTimeout(() => {
                notice.classList.add('show');
            }, 10);

            setTimeout(() => {
                notice.classList.remove('show');
                setTimeout(() => {
                    if (document.body.contains(notice)) {
                        document.body.removeChild(notice);
                    }
                }, 500); 
            }, 4000);
        }

        const wrapper = document.getElementById('footerWrapper');
        const footerTop = document.getElementById('footerTop');
        const mainFooter = document.getElementById('mainFooter');
        const upButton = document.getElementById('footer-btn-up');
        const topCloseButton = document.getElementById('footerTopClose');
        const contactLink = document.getElementById('footerContactLink');

        function setWrapperHeight() {
            if (wrapper && mainFooter && footerTop) {
                const isTopVisible = footerTop.classList.contains('show');
                wrapper.style.height = (isTopVisible ? footerTop.offsetHeight : mainFooter.offsetHeight) + 'px';
            }
        }

        function showFooterTop() {
            if (wrapper && footerTop && mainFooter) {
                footerTop.classList.add('show');
                mainFooter.classList.add('hide');
                setWrapperHeight();
            }
        }

        function showMainFooter() {
            if (wrapper && footerTop && mainFooter) {
                footerTop.classList.remove('show');
                mainFooter.classList.remove('hide');
                setWrapperHeight();
            }
        }

        window.showSubscriptionForm = showSubscriptionForm;
        window.submitSubscription = submitSubscription;

        if (upButton) upButton.addEventListener('click', showFooterTop);
        if (topCloseButton) topCloseButton.addEventListener('click', showMainFooter);
        
        if (contactLink) {
            contactLink.addEventListener('click', function(e) {
                e.preventDefault(); 
                showMainFooter();
            });
        }

        setTimeout(setWrapperHeight, 150);
        window.addEventListener('resize', setWrapperHeight);
    })();
</script>

