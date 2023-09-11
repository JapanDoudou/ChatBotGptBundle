#JapanDoudou ChatGptBundle

## Installation

### Step 1: Download JapanDoudouChatGptBundle using composer and enable the Bundle

In your composer.json, add the following git repository :

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/JapanDoudou/ChatBotGptBundle.git"
    }
  ]
}
```

Then run the following command :

```bash
$ composer require japandoudou/chatgptbundle
```

If you're using Symfony Flex, the bundle will be automatically enabled. If not, enable it by adding it to the list of
registered bundles in the app/AppKernel.php file of your project:

```php
    JapanDoudou\ChatGptBundle\JapanDoudouChatGptBundle::class => ['all' => true],
```

Finaly, enable the bundle by creating the follinwg file :

```yaml
# config/packages/japandoudou_chat_gpt.yaml
japan_doudou_chat_gpt_bundle:
  openai_key: '%env(OPEN_AI_API_KEY)%' #Mettre la clef n'est pas conseillé si vous versionnez votre code. Privilégiez un coffre ou le .env.local
  is_debug: true #enable debug mode allowws you to test the chatbot without using the API with 'debug' and 'error' as message
```
### Step 2 : Adding the CSS style

If you're using Webpack Encore and you want the default css, you can add the following line to your app.css file :

```css
@import "../../vendor/japandoudou/chatgptbundle/assets/css/_chatbot.css";
```
Then build your assets.

### Step 3: Importing the Chatbot in a page

Just include the following line in your twig template :

```html.twig
{% include '@JapanDoudouChatGpt/chatbot.html.twig' %}
```

Si tout c'est bien passé, sur la page ou vous importez le fichier twig, vous devriez voir apparaître le chatbot :
![Chatbot](assets/chatbot.png)
