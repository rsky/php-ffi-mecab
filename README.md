# php-ffi-mecab

This is a MeCab binding for PHP using FFI. And this is a successor of [php-mecab](https://github.com/rsky/php-mecab).

FFIを使って実装したPHP向けのMeCabバインディングで、[php-mecab](https://github.com/rsky/php-mecab)の後継です。

## 使い方

テキストを形態素に分解するだけのシンプルな機能をもつ `MeCab\MeCab` クラスと、MeCabの関数をラップした `MeCab\Tagger` クラスを提供します。

どちらのクラスもコンストラクタの第1引数はMeCabの共有ライブラリ (*libmecab.{so,dll,dylib等}*) のパス、第2引数はMeCabの初期化オプションです。初期化オプションに関しては[MeCabのコマンドラインオプション](https://taku910.github.io/mecab/mecab.html)をご覧ください。

### とりあえず解析してみる

`MeCab\Tagger::parse()` を使います。

```php
<?php
use MeCab\Tagger;

$tagger = new Tagger('/usr/lib/libmecab.so');
echo $tagger->parse('全ては猫様のために');
```
```
全て	名詞,副詞可能,*,*,*,*,全て,スベテ,スベテ
は	助詞,係助詞,*,*,*,*,は,ハ,ワ
猫	名詞,一般,*,*,*,*,猫,ネコ,ネコ
様	名詞,接尾,人名,*,*,*,様,サマ,サマ
の	助詞,連体化,*,*,*,*,の,ノ,ノ
ため	名詞,非自立,副詞可能,*,*,*,ため,タメ,タメ
に	助詞,格助詞,一般,*,*,*,に,ニ,ニ
EOS
```

### わかち書きをする

`MeCab\MeCab::split()` を使います。

```php
<?php
use MeCab\MeCab;

$mecab = new MeCab('/usr/lib/libmecab.so');
var_dump($mecab->split('全ては猫様のために'));
```
```
array(7) {
  [0] =>
  string(6) "全て"
  [1] =>
  string(3) "は"
  [2] =>
  string(3) "猫"
  [3] =>
  string(3) "様"
  [4] =>
  string(3) "の"
  [5] =>
  string(6) "ため"
  [6] =>
  string(3) "に"
}
```

### 高度な使い方

`MeCab\Tagger::parseToNode()` で取得した `MeCab\Node` オブジェクトを操作します。

```
<?php
use MeCab\Tagger;

$tagger = new Tagger('/usr/lib/libmecab.so');
$node = $tagger->parseToNode('全ては猫様のために');

// ...
```

N-Best解を扱うための `MeCab\Lattice` オブジェクトは今後実装予定です。
