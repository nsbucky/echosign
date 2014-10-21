# Echosign
Library for dealing with adobe echosign REST API v2. You can view the API docs here: https://secure.echosign.com/public/docs/restapi/v2

## Requirements
PHP 5.4, php ext-filter. Uses guzzlehttp as a transport, though you can plug in other ones if you want.

Please take a look at the tests to see how you can use the library. Its more or less a 1 to 1 with requests and responses for the echosign REST API.

## Installation
In the `require` key of `composer.json` file add the following

    "nsbucky/echosign": "dev-master"

## Usage
    // get a token from Echosign
    use Echosign\Token;
    $token = new Token($appId, $appSecret, $apiKey);
    $token->authenticate();

    // upload a transient document
    use Echosign\TransientDocument;
    $document = new TransientDocument($token, '/path/to/file/sample.pdf', 'application/pdf');
    $document->send();

    // create an agreement
    use Echosign\Agreement;
    use Echosign\Info\DocumentCreationInfo;
    $agreement = new Agreement($token);
    $fileInfos = new FileInfo();
    $docInfo = new DocumentCreationInfo( $fileInfos, 'test', 'user@gmail.com', \Echosign\Info\DocumentCreationInfo::SIGN_ESIGN, \Echosign\Info\DocumentCreationInfo::FLOW_NOT_REQUIRED );
    $docInfo->addTransientDocument($document);
    $response = $agreement->create($docInfo);

