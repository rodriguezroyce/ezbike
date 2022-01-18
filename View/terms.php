<?php
    session_start();
    require_once "Page.php";
    load_view("functions");

    if(isset($_SESSION["shopping_cart"])){
        $bike_id = $_SESSION["shopping_cart"]["bike_id"];
        $lessor_id = $_SESSION["shopping_cart"]["lessorid"];
        $rate_type = $_SESSION["shopping_cart"]["rate_type"];
        $pickup_date = $_SESSION["shopping_cart"]["startDate"];
        $end_date = $_SESSION["shopping_cart"]["returnDate"];
        $totalAmt = $_SESSION["shopping_cart"]["totalAmt"];
        $days = $_SESSION["shopping_cart"]["days"];
        $bike_name = $_SESSION["shopping_cart"]["bike_name"];
        $bike_types = $_SESSION["shopping_cart"]["bike_type"];
        $bike_brand = $_SESSION["shopping_cart"]["bike_brand"];
        $bike_img = $_SESSION["shopping_cart"]["bike_img"];
    }

    load_view("header");    

?>
<title>
    Terms of Use | Ezbike
</title>
</head>

<body class="bg-white">
    <?php
        include_once "messenger.php";
    ?>
    <div class="container">
        <?php
            include_once "navigation.php";
        ?>
    </div>
    <div class="container p-4">
        <div class="p-4 bg-white">
            <h3>Terms of Services</h3>
            <p class="date">Last updated: 2021-12-15</p>
            <ol>
                <!-- introduction -->
                <li id="introduction">
                    <h5>
                    Introduction
                    </h5>
                    <p>This agreement was last revised on December 15, 2021</p>
                    <p>Welcome to Ezbike, a online bicycle marketplace for bikers. These Terms of Service ("terms") describe the terms and conditions that govern your use of and participation in Ezbike Services, including our site, privacy, agreements offered by Ezbike.</p>
                    <p>For the purposes of these Terms, "you" means each person using the Service. All visitors, users, and others who access the Site and/or Service, including you and any persons that you authorize to use your account, may be referred to in these Terms as the "User."</p>
                    <p>By accessing or using the Service, you agree to be bound by these terms, as amended from time to time. If you do not agree to these Terms, you are prohibited from using or accessing the Site or the Service. Please take note that bike shops and certain other entreprenurial business may have a separate written agreement with us; in the event of any conflict between these Terms and such agreement, the terms of the written agreement will control.</p>
                </li>
                <li>
                    <h5>Our Service; Member Accounts</h5>
                    <p>Ezbike provides a platform that allows users to book a bike on our website by the nearby stores they search in our google map. The ezbike allows you to book after you register through our platform. The renter should provide legitimate information in order to monitor all of the members who are using are services. Your information would be confidential with us, we neither share your information with other businesses and all of the transactions made within our system will be just on us. </p>
                    <p>You may control your member profile by selecting your profile name on the top right of the website. Then you will be allowed to change your email, password and view the transaction made within the bicycle store. You will be receiving a email notification after you transact with the bicycle store to notify your payment receipt and provide you the store location where you are going to rent the bicycle</p>
                    <p>If you rent from a shop, we will also share your contact information with that shop to enable them to communicate with you and to provide service and marketing messages. to Opt out receiving messages from the shop, you will have to contact the bike shop directly.</p>
                </li>
                <li>
                    <h5>Policies and Procedures; Rental Confirmations; Feedback</h5>
                    <p>When you use the Service to conduct a Rental, you will be required to agree to a rental contract. The Rental Contract is an agreement between a bike shop owner and a Renter. Ezbike is not a party to the Rental Contract.</p>
                    <p>Both renters and bike shop owners are encouraged to submit feedback to the service following the completion of each rental.</p>
                    <h5>Service Rules</h5>
                    <p>In using the Service of the App, you agree not to engage in any of the following probihited activities.</p>
                    <ol id="service-rules">
                        <li>
                        copying, distributing, or disclosing any part of the Service in any medium, including without limitation by any automated or non-automated "scraping";
                        </li>
                        <li>
                        using any automated system, including without limitation "robots," "spiders," "offline readers," etc., to access the Service in a manner that sends more request messages to the Ezbike servers than a human can reasonably produce in the same period of time by using a conventional on-line web browser except that Ezbike grants the operators of public search engines revocable permission to use spiders to copy materials from Ezbike.com for the sole purpose of and solely to the extent necessary for creating publicly available searchable indices of the materials, but not caches or archives of such materials;
                        </li>
                        <li>transmitting spam, chain letters, or other unsolicited email;</li>
                        <li>
                        attempting to interfere with, compromise the system integrity or security or decipher any transmissions to or from the servers running the Service;
                        </li>
                        <li>
                        using the Site, App or Service in any manner to circumvent or secure a rental outside of the Service or to avoid fees payable to Ezbike in connection with your use of the Service;
                        </li>
                        <li>
                        taking any action that imposes, or may impose at our sole discretion an unreasonable or disproportionately large load on our infrastructure;
                        </li>
                        <li>
                        uploading invalid data, viruses, worms, or other software agents through the Service;
                        </li>
                        <li>
                        collecting or harvesting any personally identifiable information, including account names, from the Service;
                        </li>
                        <li>
                        using the Service for any commercial solicitation purposes;
                        </li>
                        <li>
                        impersonating another person or otherwise misrepresenting your affiliation with a person or entity, conducting fraud, hiding or attempting to hide your identity;
                        </li>
                        <li>
                        interfering with the proper working of the Service;
                        </li>
                        <li>
                        accessing any content on the Service through any technology or means other than those provided or authorized by the Service;
                        </li>
                        <li>
                        or bypassing the measures we may use to prevent or restrict access to the Service, including without limitation features that prevent or restrict use or copying of any content or enforce limitations on use of the Service or the content therein.
                        </li>
                    </ol>
                    <p>The Ezbike may permanently or temporarily terminate,suspend, or otherwise refuse to permit your access to the Service without notice and liability for any reason. including if in Ezbike's sole determination you violate any provision of these Terms. Ezbike also retains the right to remove or suspend listings for any reason, including a violation or suspected violation of these Terms. All aspects of the Service are subject to change or elimination at Ezbike's sole discretion. Ezbike reserves the right to interrupt the Service with or without prior notice for any reason. You agree that Ezbike will not be liable to you for any interruption of the Service, delay or failure to perform."</p>
                </li>
                <!-- availability -->
                <li>
                    <h5>Availablity</h5>
                    <p>
                    Ezbike uses reasonable efforts to ensure that the Site is available 24 hours a day, 7 days a week. However, there will be occasions when the Site may interrupted for maintenance, upgrades and emergency repairs or due to failure of telecommunications links and equipment that are beyond the control of Ezbike. Ezbike will use commercially reasonable efforts to minimize such disruption where it is within the reasonable control of Ezbike. You agree that Ezbike shall not be liable to you for any modification, suspension or discontinuance of the Site or the Service. YOU UNDERSTAND AND AGREE THAT THE SITE AND SERVICE ARE PROVIDED "AS-IS" WITHOUT ANY WARRANTY OF ANY KIND. You are responsible for obtaining access to the Site and any third party fees (such as Internet service provider or airtime charges) that you incur.
                    </p>
                </li>
                <!-- privacy -->
                <li>
                    <h5>Privacy</h5>
                    <p>We care about the privacy of our Users. Our Privacy Policy [hyperlink] outlines how we use and safeguard your information. By using the Service, you are consenting to have your personal data collected, used, transferred to and processed in the Philippines</p>
                </li>
                <li>
                    <h5>DMCA Notice</h5>
                    <p>
                    Since we respect content owner's rights, it is Ezbike's policy to respond to alleged infringement notices that comply with the Digital Millennium Copyright Act of 1998 ("DMCA"). If you believe that your copyrighted work has been copied in a way that constitutes copyright infringement and is accessible via the Service, please notify Ezbike's copyright agent as set forth in the DMCA. For your complaint to be valid under the DMCA, you must provide the following information in writing
                    </p>
                    <p class="px-4">
                        An electronic or physical signature of a person authorized to act on behalf of the copyright owner;
                    </p>
                    <p class="px-4">
                        Identification of the copyrighted work that you claim has been infringed; Identification of the material that is claimed to be infringing and where it is located on the Service;
                    </p>
                    <p class="px-4">
                        Information reasonably sufficient to permit Ezbike to contact you, such as your address, telephone number, and, e-mail address;
                    </p>
                    <p class="px-4">
                        A statement that you have a good faith belief that use of the material in the manner complained of is not authorized by the copyright owner, its agent, or law;
                    </p>
                    <p class="px-4">
                        and A statement, made under penalty of perjury, that the above information is accurate, and that you are the copyright owner or are authorized to act on behalf of the owner.
                    </p>
                    <p>
                        The above information must be submitted to the following DMCA Agent
                    </p>

                </li>

            </ol>
        </div>

    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB4yzuy4_HTFrOHFI7uesGpqRN4vCZjS4Q&libraries=places">
    </script>
    <script src="../assets/js/autoComplete.js"></script>
    <script>
    $('p').css("font-size", "15px");
    $('p').addClass("mx-4");
    $('.date').css("margin-left", "0px");
    $('.probihited_users p').css("margin-bottom", "8px");
    $('.probihited_users p').addClass("ms-5");
    $('.probihited_users p span').addClass("fw-bolder");
    $('body').addClass("ff-1");
    $('h5').addClass("ff-1 fw-bold");
    </script>
    <?php
    load_view("viewFooter");
    load_view("footer");
?>