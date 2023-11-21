<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Sangaath</title>

    <link href="https://fonts.googleapis.com/css?family=PT+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@10.7.2/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .javascript-example code { display: none; }
                    body .content .python-example code { display: none; }
                    body .content .php-example code { display: none; }
            </style>


    <script src="{{ asset("/vendor/scribe/js/theme-default-4.0.0.js") }}"></script>

</head>

<body data-languages="[&quot;javascript&quot;,&quot;python&quot;,&quot;php&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image" />
    </span>
</a>
<div class="tocify-wrapper">
            <img src="https://new-sangaath.globanet.in/images/sangaath_logo.png" alt="logo" class="logo" style="padding-top: 10px;padding-left: 10px;" width="50%"/>
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                                            <button type="button" class="lang-button" data-language-name="python">python</button>
                                            <button type="button" class="lang-button" data-language-name="php">php</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-auth" class="tocify-header">
                <li class="tocify-item level-1" data-unique="auth">
                    <a href="#auth">Auth</a>
                </li>
                                    <ul id="tocify-subheader-auth" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="auth-POSTapi-login">
                                <a href="#auth-POSTapi-login">Account login</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="auth-GETapi-profile">
                                <a href="#auth-GETapi-profile">User Profile</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-basic-data" class="tocify-header">
                <li class="tocify-item level-1" data-unique="basic-data">
                    <a href="#basic-data">Basic Data</a>
                </li>
                                    <ul id="tocify-subheader-basic-data" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="basic-data-GETapi-data-villages">
                                <a href="#basic-data-GETapi-data-villages">Alloted Villages</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="basic-data-GETapi-data-social-status">
                                <a href="#basic-data-GETapi-data-social-status">Social Status</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="basic-data-GETapi-data-household-incomes">
                                <a href="#basic-data-GETapi-data-household-incomes">Household Income</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="basic-data-GETapi-data-castes">
                                <a href="#basic-data-GETapi-data-castes">Castes</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="basic-data-GETapi-data-disability-status">
                                <a href="#basic-data-GETapi-data-disability-status">Disability Status</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="basic-data-GETapi-data-house-types">
                                <a href="#basic-data-GETapi-data-house-types">House Type</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="basic-data-GETapi-data-card-score">
                                <a href="#basic-data-GETapi-data-card-score">Card Scores</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="basic-data-GETapi-data-schemes">
                                <a href="#basic-data-GETapi-data-schemes">Schemes</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="basic-data-GETapi-data-kycs">
                                <a href="#basic-data-GETapi-data-kycs">Pre-Requisites</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-household" class="tocify-header">
                <li class="tocify-item level-1" data-unique="household">
                    <a href="#household">Household</a>
                </li>
                                    <ul id="tocify-subheader-household" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="household-GETapi-household-list--hh_row_id---update_date-">
                                <a href="#household-GETapi-household-list--hh_row_id---update_date-">Household List</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="household-GETapi-household-details--hh_id-">
                                <a href="#household-GETapi-household-details--hh_id-">Household Details</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="household-POSTapi-household-register">
                                <a href="#household-POSTapi-household-register">Register Household</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-member" class="tocify-header">
                <li class="tocify-item level-1" data-unique="member">
                    <a href="#member">Member</a>
                </li>
                                    <ul id="tocify-subheader-member" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="member-GETapi-member-list--hh_id-">
                                <a href="#member-GETapi-member-list--hh_id-">Members List</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="member-GETapi-member-details--member_id---update_date-">
                                <a href="#member-GETapi-member-details--member_id---update_date-">Members Details</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="member-GETapi-member-kycs--member_id---update_date-">
                                <a href="#member-GETapi-member-kycs--member_id---update_date-">Members KYC Details</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="member-POSTapi-member-register">
                                <a href="#member-POSTapi-member-register">Register Member</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="member-POSTapi-member-kycs-save">
                                <a href="#member-POSTapi-member-kycs-save">Add Member KYC</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="member-POSTapi-member-kycs-delete">
                                <a href="#member-POSTapi-member-kycs-delete">Delete Member KYC</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="member-GETapi-member-kycs-deleted--update_date-">
                                <a href="#member-GETapi-member-kycs-deleted--update_date-">Get Deleted KYCs</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-applications" class="tocify-header">
                <li class="tocify-item level-1" data-unique="applications">
                    <a href="#applications">Applications</a>
                </li>
                                    <ul id="tocify-subheader-applications" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="applications-GETapi-documentation-pending--update_date-">
                                <a href="#applications-GETapi-documentation-pending--update_date-">Pending Applications</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="applications-GETapi-documentation-incomplete--update_date-">
                                <a href="#applications-GETapi-documentation-incomplete--update_date-">Incomplete Applications</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="applications-GETapi-documentation-complete--update_date-">
                                <a href="#applications-GETapi-documentation-complete--update_date-">Complete Applications</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="applications-POSTapi-documentation-incomplete-save">
                                <a href="#applications-POSTapi-documentation-incomplete-save">Save Incomplete Application</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="applications-POSTapi-documentation-pending-save">
                                <a href="#applications-POSTapi-documentation-pending-save">Save Pending Application</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="applications-POSTapi-documentation-pending-delete">
                                <a href="#applications-POSTapi-documentation-pending-delete">Delete Pending Application</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="applications-POSTapi-documentation-incomplete-delete">
                                <a href="#applications-POSTapi-documentation-incomplete-delete">Delete Incomplete Application</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="applications-POSTapi-documentation-complete-delete">
                                <a href="#applications-POSTapi-documentation-complete-delete">Delete Complete Application</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="applications-GETapi-documentation-pending-deleted--update_date-">
                                <a href="#applications-GETapi-documentation-pending-deleted--update_date-">Get Deleted Pending Applications</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="applications-GETapi-documentation-incomplete-deleted--update_date-">
                                <a href="#applications-GETapi-documentation-incomplete-deleted--update_date-">Get Deleted Incomplete Applications</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="applications-GETapi-documentation-complete-deleted--update_date-">
                                <a href="#applications-GETapi-documentation-complete-deleted--update_date-">Get Deleted Complete Applications</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-follow-up" class="tocify-header">
                <li class="tocify-item level-1" data-unique="follow-up">
                    <a href="#follow-up">Follow Up</a>
                </li>
                                    <ul id="tocify-subheader-follow-up" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="follow-up-GETapi-followup-list--update_date-">
                                <a href="#follow-up-GETapi-followup-list--update_date-">Get Follow-Ups</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="follow-up-POSTapi-followup-update">
                                <a href="#follow-up-POSTapi-followup-update">Update Follow-Up</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

        <ul class="toc-footer" id="last-updated">
        <li>Last updated: October 13 2022</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>Sangaath Web &amp; Android App Documentation</p>
<p>This documentation is only for Sangaath Internal team to understand the working of Web and App API.</p>
<aside>As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).</aside>
<blockquote>
<p>Base URL</p>
</blockquote>
<pre><code class="language-yaml">https://sangaath.deepakfoundation.org/</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_AUTH_KEY}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>User need to first access the <b>/login</b> endpoint with correct email and password to get  <b>{YOUR_AUTH_KEY}</b>.</p>

        <h1 id="auth">Auth</h1>

    <p>APIs for auth management</p>

                                <h2 id="auth-POSTapi-login">Account login</h2>

<p>
</p>

<p>Login into the facilitator account to access data</p>

<span id="example-requests-POSTapi-login">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/login"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
    "application-id": "****",
    "api-key": "****",
};

let body = {
    "email": "washala@df.org",
    "password": "******"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/login'
payload = {
    "email": "washala@df.org",
    "password": "******"
}
headers = {
  'Content-Type': 'application/json',
  'Accept': 'application/json',
  'application-id': '****',
  'api-key': '****'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://sangaath.deepakfoundation.org/api/login',
    [
        'headers' =&gt; [
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
            'application-id' =&gt; '****',
            'api-key' =&gt; '****',
        ],
        'json' =&gt; [
            'email' =&gt; 'washala@df.org',
            'password' =&gt; '******',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-login">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;access_token&quot;: &quot;auth_access_token&quot;,
    &quot;application_id&quot;: &quot;sangaath_application_id&quot;,
    &quot;employee_id&quot;: &quot;user_id&quot;,
    &quot;api_key&quot;: &quot;sangaath_api_key&quot;,
    &quot;token_expires&quot;: &quot;token_expiry_date&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, incorrect login credentials):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthorized&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-login" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-login"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-login"></code></pre>
</span>
<span id="execution-error-POSTapi-login" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-login"></code></pre>
</span>
<form id="form-POSTapi-login" data-method="POST"
      data-path="api/login"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Content-Type":"application\/json","Accept":"application\/json","application-id":"****","api-key":"****"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-login', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/login</code></b>
        </p>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="email"
               data-endpoint="POSTapi-login"
               value="washala@df.org"
               data-component="body" hidden>
    <br>
<p>Email address of the user.</p>
        </p>
                <p>
            <b><code>password</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="password"
               data-endpoint="POSTapi-login"
               value="******"
               data-component="body" hidden>
    <br>
<p>Password of the user.</p>
        </p>
        </form>

                    <h2 id="auth-GETapi-profile">User Profile</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the user profile</p>

<span id="example-requests-GETapi-profile">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/profile"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/profile'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/profile',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-profile">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;employee_id&quot;: &quot;user_id&quot;,
    &quot;Employee_name&quot;: &quot;name&quot;,
    &quot;email_id&quot;: &quot;email_id&quot;,
    &quot;department_id&quot;: &quot;department_id&quot;,
    &quot;location&quot;: &quot;location&quot;,
    &quot;role&quot;: &quot;role&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-profile" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-profile"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-profile"></code></pre>
</span>
<span id="execution-error-GETapi-profile" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-profile"></code></pre>
</span>
<form id="form-GETapi-profile" data-method="GET"
      data-path="api/profile"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-profile', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/profile</code></b>
        </p>
                <p>
            <label id="auth-GETapi-profile" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-profile"
                       data-component="header"></label>
        </p>
                </form>

                <h1 id="basic-data">Basic Data</h1>

    <p>APIs to get basic data from the server</p>

                                <h2 id="basic-data-GETapi-data-villages">Alloted Villages</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the villages alloted to the user</p>

<span id="example-requests-GETapi-data-villages">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/data/villages"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/data/villages'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/data/villages',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-data-villages">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Village List&quot;,
 &quot;data&quot;: [
     [
         &quot;id&quot;: &quot;village_id&quot;,
         &quot;Value&quot;: &quot;village_name&quot;,
         &quot;State&quot;: &quot;state_name&quot;
     ]
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (100, no villages):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;No village allocated to the user&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-data-villages" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-data-villages"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-data-villages"></code></pre>
</span>
<span id="execution-error-GETapi-data-villages" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-data-villages"></code></pre>
</span>
<form id="form-GETapi-data-villages" data-method="GET"
      data-path="api/data/villages"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-data-villages', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/data/villages</code></b>
        </p>
                <p>
            <label id="auth-GETapi-data-villages" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-data-villages"
                       data-component="header"></label>
        </p>
                </form>

                    <h2 id="basic-data-GETapi-data-social-status">Social Status</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the available social statuses</p>

<span id="example-requests-GETapi-data-social-status">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/data/social-status"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/data/social-status'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/data/social-status',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-data-social-status">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Social Status List&quot;,
 &quot;data&quot;: [
     [
         &quot;id&quot;: &quot;1&quot;,
         &quot;value&quot;: &quot;APL&quot;
     ]
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-data-social-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-data-social-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-data-social-status"></code></pre>
</span>
<span id="execution-error-GETapi-data-social-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-data-social-status"></code></pre>
</span>
<form id="form-GETapi-data-social-status" data-method="GET"
      data-path="api/data/social-status"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-data-social-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/data/social-status</code></b>
        </p>
                <p>
            <label id="auth-GETapi-data-social-status" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-data-social-status"
                       data-component="header"></label>
        </p>
                </form>

                    <h2 id="basic-data-GETapi-data-household-incomes">Household Income</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the available household incomes</p>

<span id="example-requests-GETapi-data-household-incomes">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/data/household-incomes"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/data/household-incomes'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/data/household-incomes',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-data-household-incomes">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Household Income List&quot;,
 &quot;data&quot;: [
     [
         &quot;id&quot;: &quot;1&quot;,
         &quot;value&quot;: &quot;Less than 1,20,000&quot;
     ]
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-data-household-incomes" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-data-household-incomes"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-data-household-incomes"></code></pre>
</span>
<span id="execution-error-GETapi-data-household-incomes" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-data-household-incomes"></code></pre>
</span>
<form id="form-GETapi-data-household-incomes" data-method="GET"
      data-path="api/data/household-incomes"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-data-household-incomes', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/data/household-incomes</code></b>
        </p>
                <p>
            <label id="auth-GETapi-data-household-incomes" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-data-household-incomes"
                       data-component="header"></label>
        </p>
                </form>

                    <h2 id="basic-data-GETapi-data-castes">Castes</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the available castes</p>

<span id="example-requests-GETapi-data-castes">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/data/castes"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/data/castes'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/data/castes',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-data-castes">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Caste List&quot;,
 &quot;data&quot;: [
     [
         &quot;id&quot;: &quot;1&quot;,
         &quot;value&quot;: &quot;ST&quot;
     ]
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-data-castes" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-data-castes"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-data-castes"></code></pre>
</span>
<span id="execution-error-GETapi-data-castes" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-data-castes"></code></pre>
</span>
<form id="form-GETapi-data-castes" data-method="GET"
      data-path="api/data/castes"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-data-castes', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/data/castes</code></b>
        </p>
                <p>
            <label id="auth-GETapi-data-castes" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-data-castes"
                       data-component="header"></label>
        </p>
                </form>

                    <h2 id="basic-data-GETapi-data-disability-status">Disability Status</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the available disability statuses</p>

<span id="example-requests-GETapi-data-disability-status">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/data/disability-status"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/data/disability-status'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/data/disability-status',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-data-disability-status">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Disability List&quot;,
 &quot;data&quot;: [
     [
         &quot;id&quot;: &quot;1&quot;,
         &quot;value&quot;: &quot;No Disability&quot;
     ]
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-data-disability-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-data-disability-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-data-disability-status"></code></pre>
</span>
<span id="execution-error-GETapi-data-disability-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-data-disability-status"></code></pre>
</span>
<form id="form-GETapi-data-disability-status" data-method="GET"
      data-path="api/data/disability-status"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-data-disability-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/data/disability-status</code></b>
        </p>
                <p>
            <label id="auth-GETapi-data-disability-status" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-data-disability-status"
                       data-component="header"></label>
        </p>
                </form>

                    <h2 id="basic-data-GETapi-data-house-types">House Type</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the available house types</p>

<span id="example-requests-GETapi-data-house-types">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/data/house-types"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/data/house-types'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/data/house-types',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-data-house-types">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Household Type List&quot;,
 &quot;data&quot;: [
     [
         &quot;id&quot;: &quot;1&quot;,
         &quot;value&quot;: &quot;Kaccha&quot;
     ]
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-data-house-types" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-data-house-types"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-data-house-types"></code></pre>
</span>
<span id="execution-error-GETapi-data-house-types" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-data-house-types"></code></pre>
</span>
<form id="form-GETapi-data-house-types" data-method="GET"
      data-path="api/data/house-types"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-data-house-types', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/data/house-types</code></b>
        </p>
                <p>
            <label id="auth-GETapi-data-house-types" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-data-house-types"
                       data-component="header"></label>
        </p>
                </form>

                    <h2 id="basic-data-GETapi-data-card-score">Card Scores</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the available card scores</p>

<span id="example-requests-GETapi-data-card-score">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/data/card-score"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/data/card-score'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/data/card-score',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-data-card-score">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Card Score List&quot;,
 &quot;data&quot;: [
     [
         &quot;id&quot;: &quot;1&quot;,
         &quot;value&quot;: &quot;0 - 20&quot;
     ]
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-data-card-score" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-data-card-score"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-data-card-score"></code></pre>
</span>
<span id="execution-error-GETapi-data-card-score" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-data-card-score"></code></pre>
</span>
<form id="form-GETapi-data-card-score" data-method="GET"
      data-path="api/data/card-score"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-data-card-score', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/data/card-score</code></b>
        </p>
                <p>
            <label id="auth-GETapi-data-card-score" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-data-card-score"
                       data-component="header"></label>
        </p>
                </form>

                    <h2 id="basic-data-GETapi-data-schemes">Schemes</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the available schemes</p>

<span id="example-requests-GETapi-data-schemes">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/data/schemes"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/data/schemes'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/data/schemes',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-data-schemes">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;scheme_details_list&quot;,
 &quot;data&quot;: [
     [
         &quot;id&quot;: 1,
         &quot;scheme_name&quot;: &quot;Indira Gandhi National Widow Pension Scheme&quot;,
         &quot;category&quot;: &quot;State Level&quot;,
         &quot;department&quot;: &quot;Department of social security&quot;,
         &quot;req_kycs&quot;: &quot;[1,2,3,4,8,9,12,14,38,39,40,41,42]&quot;,
         &quot;rules&quot;: &quot;[[\&quot;social_status\&quot;,\&quot;BPL\&quot;],[\&quot;age\&quot;,\&quot;18\&quot;],[\&quot;gender\&quot;,\&quot;Female\&quot;],[\&quot;marital_sts\&quot;,\&quot;Widow\\/Widower\&quot;],[\&quot;aadhar_card\&quot;,\&quot;Yes\&quot;],[\&quot;bank_ac\&quot;,\&quot;Yes\&quot;],[\&quot;widow_sts\&quot;,\&quot;Widow\\/Widower\&quot;],[\&quot;status_of_women\&quot;,\&quot;No\&quot;],[\&quot;card_score\&quot;,\&quot;0 - 20\&quot;]]&quot;,
         &quot;type&quot;: &quot;Scheme&quot;,
         &quot;status&quot;: &quot;Active&quot;,
         &quot;followup_days&quot;: &quot;45&quot;,
         &quot;updated_at&quot;: &quot;2022-09-29T11:37:55.000000Z&quot;,
         &quot;created_at&quot;: &quot;2022-09-29T11:37:55.000000Z&quot;
     ]
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-data-schemes" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-data-schemes"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-data-schemes"></code></pre>
</span>
<span id="execution-error-GETapi-data-schemes" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-data-schemes"></code></pre>
</span>
<form id="form-GETapi-data-schemes" data-method="GET"
      data-path="api/data/schemes"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-data-schemes', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/data/schemes</code></b>
        </p>
                <p>
            <label id="auth-GETapi-data-schemes" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-data-schemes"
                       data-component="header"></label>
        </p>
                </form>

                    <h2 id="basic-data-GETapi-data-kycs">Pre-Requisites</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the list of available pre-requisites</p>

<span id="example-requests-GETapi-data-kycs">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/data/kycs"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/data/kycs'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/data/kycs',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-data-kycs">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;KYC_list&quot;,
 &quot;data&quot;: [
     [
         &quot;id&quot;: 1,
         &quot;kyc_name&quot;: &quot;Ration Card - Front Side&quot;
     ]
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-data-kycs" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-data-kycs"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-data-kycs"></code></pre>
</span>
<span id="execution-error-GETapi-data-kycs" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-data-kycs"></code></pre>
</span>
<form id="form-GETapi-data-kycs" data-method="GET"
      data-path="api/data/kycs"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-data-kycs', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/data/kycs</code></b>
        </p>
                <p>
            <label id="auth-GETapi-data-kycs" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-data-kycs"
                       data-component="header"></label>
        </p>
                </form>

                <h1 id="household">Household</h1>

    <p>APIs to manage household head details</p>

                                <h2 id="household-GETapi-household-list--hh_row_id---update_date-">Household List</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the list of households of the villages alloted to this user</p>

<span id="example-requests-GETapi-household-list--hh_row_id---update_date-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/household/list/0/id"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/household/list/0/id'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/household/list/0/id',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-household-list--hh_row_id---update_date-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;Village Household Details&quot;,
    &quot;data&quot;: [
        {
            &quot;villagehhid&quot;: 5687,
            &quot;village_id&quot;: 69,
            &quot;hh_id&quot;: &quot;1214001&quot;,
            &quot;hhname&quot;: &quot;Manda Hiraman Raut&quot;,
            &quot;qrcode&quot;: &quot;&quot;,
            &quot;social_status&quot;: &quot;BPL Antyodaya&quot;,
            &quot;card_disbursement_sts&quot;: 0,
            &quot;social_eco_status&quot;: &quot;BPL Antyodaya&quot;,
            &quot;card_score&quot;: &quot;&quot;,
            &quot;hh_income&quot;: &quot;Less than 30000&quot;,
            &quot;caste&quot;: &quot;OBC&quot;,
            &quot;state&quot;: &quot;Maharashtra&quot;,
            &quot;age&quot;: &quot;66&quot;,
            &quot;created_at&quot;: &quot;2022-09-29T11:37:55.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2022-09-29T11:37:55.000000Z&quot;,
            &quot;import_code&quot;: &quot;&quot;,
            &quot;tag&quot;: &quot;&quot;
        }
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-household-list--hh_row_id---update_date-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-household-list--hh_row_id---update_date-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-household-list--hh_row_id---update_date-"></code></pre>
</span>
<span id="execution-error-GETapi-household-list--hh_row_id---update_date-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-household-list--hh_row_id---update_date-"></code></pre>
</span>
<form id="form-GETapi-household-list--hh_row_id---update_date-" data-method="GET"
      data-path="api/household/list/{hh_row_id}/{update_date}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-household-list--hh_row_id---update_date-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/household/list/{hh_row_id}/{update_date}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-household-list--hh_row_id---update_date-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-household-list--hh_row_id---update_date-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>hh_row_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number"
               name="hh_row_id"
               data-endpoint="GETapi-household-list--hh_row_id---update_date-"
               value="0"
               data-component="url" hidden>
    <br>
<p>Row Id of Household.</p>
            </p>
                    <p>
                <b><code>update_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="update_date"
               data-endpoint="GETapi-household-list--hh_row_id---update_date-"
               value="id"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="household-GETapi-household-details--hh_id-">Household Details</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the details of a particular household, based upon the input parameter.</p>

<span id="example-requests-GETapi-household-details--hh_id-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/household/details/1214001"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/household/details/1214001'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/household/details/1214001',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-household-details--hh_id-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;Household Details&quot;,
    &quot;data&quot;: [
        {
            &quot;villagehhid&quot;: 5687,
            &quot;village_id&quot;: 69,
            &quot;hh_id&quot;: &quot;1214001&quot;,
            &quot;hhname&quot;: &quot;Manda Hiraman Raut&quot;,
            &quot;qrcode&quot;: &quot;&quot;,
            &quot;social_status&quot;: &quot;BPL Antyodaya&quot;,
            &quot;card_disbursement_sts&quot;: 0,
            &quot;social_eco_status&quot;: &quot;BPL Antyodaya&quot;,
            &quot;card_score&quot;: &quot;&quot;,
            &quot;hh_income&quot;: &quot;Less than 30000&quot;,
            &quot;caste&quot;: &quot;OBC&quot;,
            &quot;state&quot;: &quot;Maharashtra&quot;,
            &quot;age&quot;: &quot;66&quot;,
            &quot;created_at&quot;: &quot;2022-09-29T11:37:55.000000Z&quot;,
            &quot;updated_at&quot;: &quot;2022-09-29T11:37:55.000000Z&quot;,
            &quot;import_code&quot;: &quot;&quot;,
            &quot;tag&quot;: &quot;&quot;
        }
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (105, household not found):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;Wrong HouseHold Number or Data not found!&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-household-details--hh_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-household-details--hh_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-household-details--hh_id-"></code></pre>
</span>
<span id="execution-error-GETapi-household-details--hh_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-household-details--hh_id-"></code></pre>
</span>
<form id="form-GETapi-household-details--hh_id-" data-method="GET"
      data-path="api/household/details/{hh_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-household-details--hh_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/household/details/{hh_id}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-household-details--hh_id-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-household-details--hh_id-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>hh_id</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="hh_id"
               data-endpoint="GETapi-household-details--hh_id-"
               value="1214001"
               data-component="url" hidden>
    <br>
<p>Household Id.</p>
            </p>
                    </form>

                    <h2 id="household-POSTapi-household-register">Register Household</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Stores the newly created household in the storage</p>

<span id="example-requests-POSTapi-household-register">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/household/register"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": "{}"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/household/register'
payload = {
    "data": "{}"
}
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://sangaath.deepakfoundation.org/api/household/register',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; '{}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-household-register">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Household registration done successfully&quot;,
 &quot;data&quot;: [
     &quot;household_count&quot;: 1
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-household-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-household-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-household-register"></code></pre>
</span>
<span id="execution-error-POSTapi-household-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-household-register"></code></pre>
</span>
<form id="form-POSTapi-household-register" data-method="POST"
      data-path="api/household/register"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-household-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/household/register</code></b>
        </p>
                <p>
            <label id="auth-POSTapi-household-register" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="POSTapi-household-register"
                       data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>data</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
 &nbsp;
                <input type="text"
               name="data"
               data-endpoint="POSTapi-household-register"
               value="{}"
               data-component="body" hidden>
    <br>
<p>Household details.</p>
        </p>
        </form>

                <h1 id="member">Member</h1>

    <p>APIs to manage household members</p>

                                <h2 id="member-GETapi-member-list--hh_id-">Members List</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the list of members of the particular hhId, if the input param is 0 all members are returned</p>

<span id="example-requests-GETapi-member-list--hh_id-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/member/list/0"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/member/list/0'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/member/list/0',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-member-list--hh_id-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Household Member Details&quot;,
 &quot;data&quot;: [
     &quot;household_members&quot;: [
         {
             &quot;village_id&quot;: 69,
             &quot;member_id&quot;: 121400101,
             &quot;member_name&quot;: &quot;Manda hiraman raut&quot;,
             &quot;member_number&quot;: 1,
             &quot;household_number&quot;: &quot;1214001&quot;
         }
     ]
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-member-list--hh_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-member-list--hh_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-member-list--hh_id-"></code></pre>
</span>
<span id="execution-error-GETapi-member-list--hh_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-member-list--hh_id-"></code></pre>
</span>
<form id="form-GETapi-member-list--hh_id-" data-method="GET"
      data-path="api/member/list/{hh_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-member-list--hh_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/member/list/{hh_id}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-member-list--hh_id-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-member-list--hh_id-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>hh_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number"
               name="hh_id"
               data-endpoint="GETapi-member-list--hh_id-"
               value="0"
               data-component="url" hidden>
    <br>
<p>HH Id of Household.</p>
            </p>
                    </form>

                    <h2 id="member-GETapi-member-details--member_id---update_date-">Members Details</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the details of members of the particular memberId</p>

<span id="example-requests-GETapi-member-details--member_id---update_date-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/member/details/0/ipsum"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/member/details/0/ipsum'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/member/details/0/ipsum',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-member-details--member_id---update_date-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;Member Kyc Details&quot;,
    &quot;data&quot;: [
        [
            {
                &quot;id&quot;: 26532,
                &quot;village_id&quot;: 69,
                &quot;hh_id&quot;: &quot;1214001&quot;,
                &quot;member_id&quot;: &quot;121400101&quot;,
                &quot;name&quot;: &quot;Manda hiraman raut&quot;,
                &quot;full_address&quot;: &quot;Washala&quot;,
                &quot;landmark&quot;: &quot;&quot;,
                &quot;age&quot;: &quot;66&quot;,
                &quot;marital_status&quot;: &quot;widow_widower&quot;,
                &quot;gender&quot;: &quot;female&quot;,
                &quot;income&quot;: &quot;&quot;,
                &quot;type_of_house&quot;: &quot;&quot;,
                &quot;disability&quot;: &quot;no_disability&quot;,
                &quot;status_of_women&quot;: &quot;No&quot;,
                &quot;religion&quot;: &quot;&quot;,
                &quot;land_ownership&quot;: &quot;&quot;,
                &quot;height_cm&quot;: &quot;0&quot;,
                &quot;weight_kg&quot;: &quot;0&quot;,
                &quot;created_at&quot;: &quot;2022-09-29T11:37:55.000000Z&quot;,
                &quot;updated_at&quot;: &quot;2022-09-29T11:37:55.000000Z&quot;,
                &quot;marital_sts&quot;: &quot;widow_widower&quot;,
                &quot;caste_cf&quot;: &quot;Don&#039;t know&quot;,
                &quot;aadhar_card&quot;: &quot;Yes&quot;,
                &quot;bank_ac&quot;: &quot;Yes&quot;,
                &quot;ele_card&quot;: &quot;Yes&quot;,
                &quot;widow_sts&quot;: &quot;widow_widower&quot;,
                &quot;education_sts&quot;: &quot;-1&quot;,
                &quot;caste&quot;: &quot;OBC&quot;,
                &quot;social_status&quot;: &quot;bpl_antyodaya&quot;,
                &quot;card_score&quot;: &quot;&quot;,
                &quot;state&quot;: &quot;Maharashtra&quot;
            }
        ]
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-member-details--member_id---update_date-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-member-details--member_id---update_date-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-member-details--member_id---update_date-"></code></pre>
</span>
<span id="execution-error-GETapi-member-details--member_id---update_date-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-member-details--member_id---update_date-"></code></pre>
</span>
<form id="form-GETapi-member-details--member_id---update_date-" data-method="GET"
      data-path="api/member/details/{member_id}/{update_date}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-member-details--member_id---update_date-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/member/details/{member_id}/{update_date}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-member-details--member_id---update_date-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-member-details--member_id---update_date-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>member_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number"
               name="member_id"
               data-endpoint="GETapi-member-details--member_id---update_date-"
               value="0"
               data-component="url" hidden>
    <br>
<p>Member Id of Household.</p>
            </p>
                    <p>
                <b><code>update_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="update_date"
               data-endpoint="GETapi-member-details--member_id---update_date-"
               value="ipsum"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="member-GETapi-member-kycs--member_id---update_date-">Members KYC Details</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the member KYC documents</p>

<span id="example-requests-GETapi-member-kycs--member_id---update_date-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/member/kycs/0/consequuntur"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/member/kycs/0/consequuntur'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/member/kycs/0/consequuntur',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-member-kycs--member_id---update_date-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;Member Kyc Details&quot;,
    &quot;data&quot;: [
        [
            {
                &quot;id&quot;: 3,
                &quot;name&quot;: &quot;Another Test&quot;,
                &quot;hh_id&quot;: &quot;123456789014&quot;,
                &quot;member_id&quot;: &quot;1234567890141&quot;,
                &quot;kyc_id&quot;: 1,
                &quot;kyc_file_name&quot;: &quot;1234567890141-1-1664673159.jpg&quot;,
                &quot;kyc_remarks&quot;: &quot;&quot;,
                &quot;member_unique_id&quot;: null,
                &quot;kyc_name&quot;: &quot;Ration Card - Front Side&quot;,
                &quot;updated_at&quot;: &quot;2022-10-02T01:12:39.000000Z&quot;,
                &quot;created_at&quot;: &quot;2022-10-02T01:12:39.000000Z&quot;
            }
        ]
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-member-kycs--member_id---update_date-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-member-kycs--member_id---update_date-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-member-kycs--member_id---update_date-"></code></pre>
</span>
<span id="execution-error-GETapi-member-kycs--member_id---update_date-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-member-kycs--member_id---update_date-"></code></pre>
</span>
<form id="form-GETapi-member-kycs--member_id---update_date-" data-method="GET"
      data-path="api/member/kycs/{member_id}/{update_date}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-member-kycs--member_id---update_date-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/member/kycs/{member_id}/{update_date}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-member-kycs--member_id---update_date-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-member-kycs--member_id---update_date-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>member_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number"
               name="member_id"
               data-endpoint="GETapi-member-kycs--member_id---update_date-"
               value="0"
               data-component="url" hidden>
    <br>
<p>Member Id of Household.</p>
            </p>
                    <p>
                <b><code>update_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="update_date"
               data-endpoint="GETapi-member-kycs--member_id---update_date-"
               value="consequuntur"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="member-POSTapi-member-register">Register Member</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Stores the newly created member in the storage</p>

<span id="example-requests-POSTapi-member-register">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/member/register"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": "{}"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/member/register'
payload = {
    "data": "{}"
}
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://sangaath.deepakfoundation.org/api/member/register',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; '{}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-member-register">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Household new member added successfully&quot;,
 &quot;data&quot;: [
     &quot;member_count&quot;: 1
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-member-register" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-member-register"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-member-register"></code></pre>
</span>
<span id="execution-error-POSTapi-member-register" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-member-register"></code></pre>
</span>
<form id="form-POSTapi-member-register" data-method="POST"
      data-path="api/member/register"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-member-register', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/member/register</code></b>
        </p>
                <p>
            <label id="auth-POSTapi-member-register" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="POSTapi-member-register"
                       data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>data</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
 &nbsp;
                <input type="text"
               name="data"
               data-endpoint="POSTapi-member-register"
               value="{}"
               data-component="body" hidden>
    <br>
<p>Member details.</p>
        </p>
        </form>

                    <h2 id="member-POSTapi-member-kycs-save">Add Member KYC</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Stores the member KYC document in the storage</p>

<span id="example-requests-POSTapi-member-kycs-save">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/member/kycs-save"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": "{}"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/member/kycs-save'
payload = {
    "data": "{}"
}
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://sangaath.deepakfoundation.org/api/member/kycs-save',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; '{}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-member-kycs-save">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Member pre-requsite details updated successfully&quot;,
 &quot;data&quot;: [
     &quot;member_kyc_count&quot;: 1
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-member-kycs-save" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-member-kycs-save"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-member-kycs-save"></code></pre>
</span>
<span id="execution-error-POSTapi-member-kycs-save" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-member-kycs-save"></code></pre>
</span>
<form id="form-POSTapi-member-kycs-save" data-method="POST"
      data-path="api/member/kycs-save"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-member-kycs-save', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/member/kycs-save</code></b>
        </p>
                <p>
            <label id="auth-POSTapi-member-kycs-save" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="POSTapi-member-kycs-save"
                       data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>data</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
 &nbsp;
                <input type="text"
               name="data"
               data-endpoint="POSTapi-member-kycs-save"
               value="{}"
               data-component="body" hidden>
    <br>
<p>Member KYC details.</p>
        </p>
        </form>

                    <h2 id="member-POSTapi-member-kycs-delete">Delete Member KYC</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Delete the member KYC document from the storage</p>

<span id="example-requests-POSTapi-member-kycs-delete">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/member/kycs-delete"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": "{}"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/member/kycs-delete'
payload = {
    "data": "{}"
}
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://sangaath.deepakfoundation.org/api/member/kycs-delete',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; '{}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-member-kycs-delete">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;KYC Detail has been deleted&quot;,
    &quot;data&quot;: []
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-member-kycs-delete" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-member-kycs-delete"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-member-kycs-delete"></code></pre>
</span>
<span id="execution-error-POSTapi-member-kycs-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-member-kycs-delete"></code></pre>
</span>
<form id="form-POSTapi-member-kycs-delete" data-method="POST"
      data-path="api/member/kycs-delete"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-member-kycs-delete', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/member/kycs-delete</code></b>
        </p>
                <p>
            <label id="auth-POSTapi-member-kycs-delete" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="POSTapi-member-kycs-delete"
                       data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>data</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
 &nbsp;
                <input type="text"
               name="data"
               data-endpoint="POSTapi-member-kycs-delete"
               value="{}"
               data-component="body" hidden>
    <br>
<p>Deleting KYC details.</p>
        </p>
        </form>

                    <h2 id="member-GETapi-member-kycs-deleted--update_date-">Get Deleted KYCs</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the deleted kyc documents of the member</p>

<span id="example-requests-GETapi-member-kycs-deleted--update_date-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/member/kycs-deleted/fuga"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/member/kycs-deleted/fuga'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/member/kycs-deleted/fuga',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-member-kycs-deleted--update_date-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;Deleted KYC Document Details&quot;,
    &quot;data&quot;: [
        {
            &quot;KYC_ID&quot;: 1
        }
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-member-kycs-deleted--update_date-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-member-kycs-deleted--update_date-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-member-kycs-deleted--update_date-"></code></pre>
</span>
<span id="execution-error-GETapi-member-kycs-deleted--update_date-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-member-kycs-deleted--update_date-"></code></pre>
</span>
<form id="form-GETapi-member-kycs-deleted--update_date-" data-method="GET"
      data-path="api/member/kycs-deleted/{update_date}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-member-kycs-deleted--update_date-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/member/kycs-deleted/{update_date}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-member-kycs-deleted--update_date-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-member-kycs-deleted--update_date-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>update_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="update_date"
               data-endpoint="GETapi-member-kycs-deleted--update_date-"
               value="fuga"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                <h1 id="applications">Applications</h1>

    <p>APIs to manage applications of the users</p>

                                <h2 id="applications-GETapi-documentation-pending--update_date-">Pending Applications</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the list of pending applications</p>

<span id="example-requests-GETapi-documentation-pending--update_date-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/documentation/pending/0"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/documentation/pending/0'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/documentation/pending/0',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-documentation-pending--update_date-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;Pending Application Details&quot;,
    &quot;data&quot;: [
        [
            {
                &quot;Name&quot;: &quot;Manda hiraman raut&quot;,
                &quot;Villagename&quot;: &quot;Washala&quot;,
                &quot;ApplicationDetails&quot;: &quot;121400101-1&quot;,
                &quot;AppliedFor&quot;: &quot;Indira Gandhi National Widow Pension Scheme&quot;,
                &quot;AppliedDate&quot;: &quot;2022-10-01&quot;,
                &quot;hh_id&quot;: &quot;1214001&quot;,
                &quot;member_id&quot;: &quot;12140011&quot;,
                &quot;scheme_id&quot;: &quot;1&quot;
            }
        ]
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-documentation-pending--update_date-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-documentation-pending--update_date-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-documentation-pending--update_date-"></code></pre>
</span>
<span id="execution-error-GETapi-documentation-pending--update_date-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-documentation-pending--update_date-"></code></pre>
</span>
<form id="form-GETapi-documentation-pending--update_date-" data-method="GET"
      data-path="api/documentation/pending/{update_date}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-documentation-pending--update_date-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/documentation/pending/{update_date}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-documentation-pending--update_date-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-documentation-pending--update_date-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>update_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="update_date"
               data-endpoint="GETapi-documentation-pending--update_date-"
               value="0"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="applications-GETapi-documentation-incomplete--update_date-">Incomplete Applications</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the list of incomplete applications</p>

<span id="example-requests-GETapi-documentation-incomplete--update_date-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/documentation/incomplete/0"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/documentation/incomplete/0'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/documentation/incomplete/0',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-documentation-incomplete--update_date-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Incomplete Application Details&quot;,
 &quot;data&quot;: [
     [
         {
             &quot;Name&quot;: &quot;Manda hiraman raut&quot;,
             &quot;Villagename&quot;: &quot;Washala&quot;,
             &quot;TempID&quot;: 1,
             &quot;ApplicationDetails&quot;: &quot;121400101-1&quot;,
             &quot;AppliedFor&quot;: &quot;Indira Gandhi National Widow Pension Scheme&quot;,
             &quot;hh_id&quot;: &quot;1214001&quot;,
             &quot;member_id&quot;: &quot;12140011&quot;,
             &quot;scheme_id&quot;: &quot;1&quot;,
             &quot;created_at&quot;: &quot;2022-09-29T11:37:55.000000Z&quot;,
             &quot;updated_at&quot;: &quot;2022-09-29T11:37:55.000000Z&quot;,
         }
     ]
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-documentation-incomplete--update_date-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-documentation-incomplete--update_date-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-documentation-incomplete--update_date-"></code></pre>
</span>
<span id="execution-error-GETapi-documentation-incomplete--update_date-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-documentation-incomplete--update_date-"></code></pre>
</span>
<form id="form-GETapi-documentation-incomplete--update_date-" data-method="GET"
      data-path="api/documentation/incomplete/{update_date}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-documentation-incomplete--update_date-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/documentation/incomplete/{update_date}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-documentation-incomplete--update_date-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-documentation-incomplete--update_date-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>update_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="update_date"
               data-endpoint="GETapi-documentation-incomplete--update_date-"
               value="0"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="applications-GETapi-documentation-complete--update_date-">Complete Applications</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the list of complete applications</p>

<span id="example-requests-GETapi-documentation-complete--update_date-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/documentation/complete/0"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/documentation/complete/0'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/documentation/complete/0',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-documentation-complete--update_date-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;Complete Application Details&quot;,
    &quot;data&quot;: [
        [
            {
                &quot;Name&quot;: &quot;Manda hiraman raut&quot;,
                &quot;Villagename&quot;: &quot;Washala&quot;,
                &quot;TempID&quot;: 1,
                &quot;ApplicationDetails&quot;: &quot;121400101-1&quot;,
                &quot;AppliedFor&quot;: &quot;Indira Gandhi National Widow Pension Scheme&quot;,
                &quot;AppliedDate&quot;: &quot;2022-10-01&quot;,
                &quot;Document_status&quot;: &quot;Documentation_Complete&quot;,
                &quot;Document_completed_Date&quot;: &quot;2022-10-01&quot;,
                &quot;Date of verify by FS&quot;: &quot;2022-10-03&quot;,
                &quot;Date of Submitted to Govt&quot;: &quot;2022-10-05&quot;,
                &quot;hh_id&quot;: &quot;1214001&quot;,
                &quot;member_id&quot;: &quot;12140011&quot;,
                &quot;scheme_id&quot;: &quot;1&quot;
            }
        ]
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-documentation-complete--update_date-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-documentation-complete--update_date-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-documentation-complete--update_date-"></code></pre>
</span>
<span id="execution-error-GETapi-documentation-complete--update_date-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-documentation-complete--update_date-"></code></pre>
</span>
<form id="form-GETapi-documentation-complete--update_date-" data-method="GET"
      data-path="api/documentation/complete/{update_date}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-documentation-complete--update_date-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/documentation/complete/{update_date}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-documentation-complete--update_date-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-documentation-complete--update_date-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>update_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="update_date"
               data-endpoint="GETapi-documentation-complete--update_date-"
               value="0"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="applications-POSTapi-documentation-incomplete-save">Save Incomplete Application</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Stores the incomplete application in the storage</p>

<span id="example-requests-POSTapi-documentation-incomplete-save">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/documentation/incomplete-save"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": "{}"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/documentation/incomplete-save'
payload = {
    "data": "{}"
}
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://sangaath.deepakfoundation.org/api/documentation/incomplete-save',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; '{}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-documentation-incomplete-save">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Incomplete Application Details&quot;,
 &quot;data&quot;: [
     &quot;Incomplete_application_count&quot;: 1
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-documentation-incomplete-save" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-documentation-incomplete-save"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documentation-incomplete-save"></code></pre>
</span>
<span id="execution-error-POSTapi-documentation-incomplete-save" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documentation-incomplete-save"></code></pre>
</span>
<form id="form-POSTapi-documentation-incomplete-save" data-method="POST"
      data-path="api/documentation/incomplete-save"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-documentation-incomplete-save', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/documentation/incomplete-save</code></b>
        </p>
                <p>
            <label id="auth-POSTapi-documentation-incomplete-save" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="POSTapi-documentation-incomplete-save"
                       data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>data</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
 &nbsp;
                <input type="text"
               name="data"
               data-endpoint="POSTapi-documentation-incomplete-save"
               value="{}"
               data-component="body" hidden>
    <br>
<p>Member details.</p>
        </p>
        </form>

                    <h2 id="applications-POSTapi-documentation-pending-save">Save Pending Application</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Stores the pending application in the storage</p>

<span id="example-requests-POSTapi-documentation-pending-save">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/documentation/pending-save"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": "{}"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/documentation/pending-save'
payload = {
    "data": "{}"
}
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://sangaath.deepakfoundation.org/api/documentation/pending-save',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; '{}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-documentation-pending-save">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
 &quot;status&quot;: &quot;success&quot;,
 &quot;Message&quot;: &quot;Pending Application Details&quot;,
 &quot;data&quot;: [
     &quot;Pending_application_count&quot;: 1
 ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-documentation-pending-save" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-documentation-pending-save"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documentation-pending-save"></code></pre>
</span>
<span id="execution-error-POSTapi-documentation-pending-save" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documentation-pending-save"></code></pre>
</span>
<form id="form-POSTapi-documentation-pending-save" data-method="POST"
      data-path="api/documentation/pending-save"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-documentation-pending-save', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/documentation/pending-save</code></b>
        </p>
                <p>
            <label id="auth-POSTapi-documentation-pending-save" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="POSTapi-documentation-pending-save"
                       data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>data</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
 &nbsp;
                <input type="text"
               name="data"
               data-endpoint="POSTapi-documentation-pending-save"
               value="{}"
               data-component="body" hidden>
    <br>
<p>Member details.</p>
        </p>
        </form>

                    <h2 id="applications-POSTapi-documentation-pending-delete">Delete Pending Application</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Delete the pending application from the storage</p>

<span id="example-requests-POSTapi-documentation-pending-delete">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/documentation/pending-delete"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": "{}"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/documentation/pending-delete'
payload = {
    "data": "{}"
}
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://sangaath.deepakfoundation.org/api/documentation/pending-delete',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; '{}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-documentation-pending-delete">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;PendingApplication has been deleted&quot;,
    &quot;data&quot;: []
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-documentation-pending-delete" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-documentation-pending-delete"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documentation-pending-delete"></code></pre>
</span>
<span id="execution-error-POSTapi-documentation-pending-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documentation-pending-delete"></code></pre>
</span>
<form id="form-POSTapi-documentation-pending-delete" data-method="POST"
      data-path="api/documentation/pending-delete"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-documentation-pending-delete', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/documentation/pending-delete</code></b>
        </p>
                <p>
            <label id="auth-POSTapi-documentation-pending-delete" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="POSTapi-documentation-pending-delete"
                       data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>data</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
 &nbsp;
                <input type="text"
               name="data"
               data-endpoint="POSTapi-documentation-pending-delete"
               value="{}"
               data-component="body" hidden>
    <br>
<p>Deleting KYC details.</p>
        </p>
        </form>

                    <h2 id="applications-POSTapi-documentation-incomplete-delete">Delete Incomplete Application</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Delete the incomplete application from the storage</p>

<span id="example-requests-POSTapi-documentation-incomplete-delete">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/documentation/incomplete-delete"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": "{}"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/documentation/incomplete-delete'
payload = {
    "data": "{}"
}
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://sangaath.deepakfoundation.org/api/documentation/incomplete-delete',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; '{}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-documentation-incomplete-delete">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;Incomplete has been deleted.&quot;,
    &quot;data&quot;: []
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-documentation-incomplete-delete" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-documentation-incomplete-delete"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documentation-incomplete-delete"></code></pre>
</span>
<span id="execution-error-POSTapi-documentation-incomplete-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documentation-incomplete-delete"></code></pre>
</span>
<form id="form-POSTapi-documentation-incomplete-delete" data-method="POST"
      data-path="api/documentation/incomplete-delete"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-documentation-incomplete-delete', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/documentation/incomplete-delete</code></b>
        </p>
                <p>
            <label id="auth-POSTapi-documentation-incomplete-delete" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="POSTapi-documentation-incomplete-delete"
                       data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>data</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
 &nbsp;
                <input type="text"
               name="data"
               data-endpoint="POSTapi-documentation-incomplete-delete"
               value="{}"
               data-component="body" hidden>
    <br>
<p>Deleting KYC details.</p>
        </p>
        </form>

                    <h2 id="applications-POSTapi-documentation-complete-delete">Delete Complete Application</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Delete the complete application from the storage</p>

<span id="example-requests-POSTapi-documentation-complete-delete">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/documentation/complete-delete"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": "{}"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/documentation/complete-delete'
payload = {
    "data": "{}"
}
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://sangaath.deepakfoundation.org/api/documentation/complete-delete',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; '{}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-documentation-complete-delete">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;CompleteApplication has been deleted.&quot;,
    &quot;data&quot;: []
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-documentation-complete-delete" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-documentation-complete-delete"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-documentation-complete-delete"></code></pre>
</span>
<span id="execution-error-POSTapi-documentation-complete-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-documentation-complete-delete"></code></pre>
</span>
<form id="form-POSTapi-documentation-complete-delete" data-method="POST"
      data-path="api/documentation/complete-delete"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-documentation-complete-delete', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/documentation/complete-delete</code></b>
        </p>
                <p>
            <label id="auth-POSTapi-documentation-complete-delete" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="POSTapi-documentation-complete-delete"
                       data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>data</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
 &nbsp;
                <input type="text"
               name="data"
               data-endpoint="POSTapi-documentation-complete-delete"
               value="{}"
               data-component="body" hidden>
    <br>
<p>Deleting KYC details.</p>
        </p>
        </form>

                    <h2 id="applications-GETapi-documentation-pending-deleted--update_date-">Get Deleted Pending Applications</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the deleted pending applications of the member</p>

<span id="example-requests-GETapi-documentation-pending-deleted--update_date-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/documentation/pending-deleted/enim"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/documentation/pending-deleted/enim'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/documentation/pending-deleted/enim',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-documentation-pending-deleted--update_date-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;Deleted pending Application Details&quot;,
    &quot;data&quot;: [
        {
            &quot;application_details&quot;: 1
        }
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-documentation-pending-deleted--update_date-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-documentation-pending-deleted--update_date-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-documentation-pending-deleted--update_date-"></code></pre>
</span>
<span id="execution-error-GETapi-documentation-pending-deleted--update_date-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-documentation-pending-deleted--update_date-"></code></pre>
</span>
<form id="form-GETapi-documentation-pending-deleted--update_date-" data-method="GET"
      data-path="api/documentation/pending-deleted/{update_date}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-documentation-pending-deleted--update_date-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/documentation/pending-deleted/{update_date}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-documentation-pending-deleted--update_date-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-documentation-pending-deleted--update_date-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>update_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="update_date"
               data-endpoint="GETapi-documentation-pending-deleted--update_date-"
               value="enim"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="applications-GETapi-documentation-incomplete-deleted--update_date-">Get Deleted Incomplete Applications</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the deleted incomplete applications of the member</p>

<span id="example-requests-GETapi-documentation-incomplete-deleted--update_date-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/documentation/incomplete-deleted/quis"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/documentation/incomplete-deleted/quis'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/documentation/incomplete-deleted/quis',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-documentation-incomplete-deleted--update_date-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;Deleted Incomplete Application Details&quot;,
    &quot;data&quot;: [
        {
            &quot;TempID&quot;: 1
        }
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-documentation-incomplete-deleted--update_date-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-documentation-incomplete-deleted--update_date-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-documentation-incomplete-deleted--update_date-"></code></pre>
</span>
<span id="execution-error-GETapi-documentation-incomplete-deleted--update_date-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-documentation-incomplete-deleted--update_date-"></code></pre>
</span>
<form id="form-GETapi-documentation-incomplete-deleted--update_date-" data-method="GET"
      data-path="api/documentation/incomplete-deleted/{update_date}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-documentation-incomplete-deleted--update_date-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/documentation/incomplete-deleted/{update_date}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-documentation-incomplete-deleted--update_date-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-documentation-incomplete-deleted--update_date-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>update_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="update_date"
               data-endpoint="GETapi-documentation-incomplete-deleted--update_date-"
               value="quis"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="applications-GETapi-documentation-complete-deleted--update_date-">Get Deleted Complete Applications</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the deleted complete applications of the member</p>

<span id="example-requests-GETapi-documentation-complete-deleted--update_date-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/documentation/complete-deleted/ab"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/documentation/complete-deleted/ab'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/documentation/complete-deleted/ab',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-documentation-complete-deleted--update_date-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;Deleted complete Application Details&quot;,
    &quot;data&quot;: [
        {
            &quot;application_details&quot;: 1
        }
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-documentation-complete-deleted--update_date-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-documentation-complete-deleted--update_date-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-documentation-complete-deleted--update_date-"></code></pre>
</span>
<span id="execution-error-GETapi-documentation-complete-deleted--update_date-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-documentation-complete-deleted--update_date-"></code></pre>
</span>
<form id="form-GETapi-documentation-complete-deleted--update_date-" data-method="GET"
      data-path="api/documentation/complete-deleted/{update_date}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-documentation-complete-deleted--update_date-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/documentation/complete-deleted/{update_date}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-documentation-complete-deleted--update_date-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-documentation-complete-deleted--update_date-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>update_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="update_date"
               data-endpoint="GETapi-documentation-complete-deleted--update_date-"
               value="ab"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                <h1 id="follow-up">Follow Up</h1>

    <p>APIs to manage followup details of the users</p>

                                <h2 id="follow-up-GETapi-followup-list--update_date-">Get Follow-Ups</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Returns the list of pending followups</p>

<span id="example-requests-GETapi-followup-list--update_date-">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/followup/list/0"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/followup/list/0'
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;get(
    'https://sangaath.deepakfoundation.org/api/followup/list/0',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-GETapi-followup-list--update_date-">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;Get Follow-up Details.&quot;,
    &quot;data&quot;: [
        [
            {
                &quot;Name&quot;: &quot;Manda hiraman raut&quot;,
                &quot;Villagename&quot;: &quot;Washala&quot;,
                &quot;ApplicationDetails&quot;: &quot;121400101-1&quot;,
                &quot;AppliedSchemeName&quot;: &quot;Indira Gandhi National Widow Pension Scheme&quot;,
                &quot;ApplicationDate&quot;: &quot;2022-10-01&quot;,
                &quot;FollowUpDays&quot;: 10,
                &quot;FollowUpDate&quot;: &quot;2022-10-112&quot;,
                &quot;hh_id&quot;: &quot;1214001&quot;,
                &quot;member_id&quot;: &quot;12140011&quot;,
                &quot;scheme_id&quot;: &quot;1&quot;
            }
        ]
    ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-followup-list--update_date-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-followup-list--update_date-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-followup-list--update_date-"></code></pre>
</span>
<span id="execution-error-GETapi-followup-list--update_date-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-followup-list--update_date-"></code></pre>
</span>
<form id="form-GETapi-followup-list--update_date-" data-method="GET"
      data-path="api/followup/list/{update_date}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-followup-list--update_date-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/followup/list/{update_date}</code></b>
        </p>
                <p>
            <label id="auth-GETapi-followup-list--update_date-" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="GETapi-followup-list--update_date-"
                       data-component="header"></label>
        </p>
                <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <p>
                <b><code>update_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text"
               name="update_date"
               data-endpoint="GETapi-followup-list--update_date-"
               value="0"
               data-component="url" hidden>
    <br>

            </p>
                    </form>

                    <h2 id="follow-up-POSTapi-followup-update">Update Follow-Up</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Saves the follow-up details in the storage</p>

<span id="example-requests-POSTapi-followup-update">
<blockquote>Example request:</blockquote>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "https://sangaath.deepakfoundation.org/api/followup/update"
);

const headers = {
    "Authorization": "Bearer access_token",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "data": "{}"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'https://sangaath.deepakfoundation.org/api/followup/update'
payload = {
    "data": "{}"
}
headers = {
  'Authorization': 'Bearer access_token',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$response = $client-&gt;post(
    'https://sangaath.deepakfoundation.org/api/followup/update',
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer access_token',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'data' =&gt; '{}',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>

</span>

<span id="example-responses-POSTapi-followup-update">
            <blockquote>
            <p>Example response (200, success):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;status&quot;: &quot;success&quot;,
    &quot;Message&quot;: &quot;FollowUp Detail has been updated.&quot;,
    &quot;data&quot;: []
}</code>
 </pre>
            <blockquote>
            <p>Example response (401, unauthenticated):</p>
        </blockquote>
                <pre>

<code class="language-json">{
    &quot;message&quot;: &quot;User is unauthenticated&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-followup-update" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-followup-update"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-followup-update"></code></pre>
</span>
<span id="execution-error-POSTapi-followup-update" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-followup-update"></code></pre>
</span>
<form id="form-POSTapi-followup-update" data-method="POST"
      data-path="api/followup/update"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      data-headers='{"Authorization":"Bearer access_token","Content-Type":"application\/json","Accept":"application\/json"}'
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-followup-update', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/followup/update</code></b>
        </p>
                <p>
            <label id="auth-POSTapi-followup-update" hidden>Authorization header:
                <b><code>Bearer </code></b>
                <input type="text"
                       name="Authorization"
                       data-prefix="Bearer "
                       data-endpoint="POSTapi-followup-update"
                       data-component="header"></label>
        </p>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <p>
            <b><code>data</code></b>&nbsp;&nbsp;
<small>json</small>&nbsp;
 &nbsp;
                <input type="text"
               name="data"
               data-endpoint="POSTapi-followup-update"
               value="{}"
               data-component="body" hidden>
    <br>
<p>Member details.</p>
        </p>
        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                                                        <button type="button" class="lang-button" data-language-name="python">python</button>
                                                        <button type="button" class="lang-button" data-language-name="php">php</button>
                            </div>
            </div>
</div>
</body>
</html>
