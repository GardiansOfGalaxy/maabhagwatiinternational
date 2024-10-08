Bake コンソール
################

CakePHP の bake コンソールは、迅速に CakePHP を動作させるまでを支援します。
bake コンソールは、CakePHP の基本的な素材(モデル、ビヘイビアー、ビュー、ヘルパー、
コントローラー、コンポーネント、テストケース、フィクスチャー、プラグイン)を作成できます。
その為のスケルトンクラスについては、ここでは省略しますが、
bake は数分で完全に機能するアプリケーションを作成できます。
要するに、bake は足場の組まれたアプリケーションをいっぺんに手に入れるためにうってつけの方法です。

インストール手順
=================

bake を使用したり拡張する前に、アプリケーションに bake をインストールしておいてください。
bake は Composer を使ってインストールするプラグインとして提供されています。 ::

    composer require --dev cakephp/bake:"^2.0"

上記のコマンドは、bake を開発環境で使用するパッケージとしてインストールします。
この入れ方の場合、本番環境としてデプロイする際には、 bake はインストールされません。

Twig テンプレートを使用する場合、 ``Cake/Twighome`` プラグインをブートストラップとともに
読み込んでいることを確認してください。それを完全に省略して、
Bake プラグインにこのプラグインを読み込ませることもできます。

.. meta::
    :title lang=ja: Bakeコンソール
    :keywords lang=ja: コマンドライン,CLI,development,bake home, bake template syntax,erb tags,asp tags,percent tags
