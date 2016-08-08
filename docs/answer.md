# 入社試験（仮）


### 最低ライン

* SQL Injection.
* registerAction で、getで受け取るのはマズイのでは。
* CSRFは？
* なんでもselect * from... でとるのいくない
* list で sql が三回発行されんのよくない

### 中級ライン

* listAction で最初の一件だけcounterが追加されてるけどいいの？(バグ)
* validationは？
* なんで全部publicなん？
* container とか存在保証しないとやばくない？
* ORマッパー使おう。
* mysqlでincrementしようよ.transactionか。

### 上級ライン

* url routing で id解決しようよ
* register action なんか返そうよ
* そもそもArticleModel ってサービスっぽいものが状態を持つのはどうなの？
* そもそもDIコンテナをサービスに渡すのはよくない。
* 早期リターンしよう。
* trueとか返さずにException投げようよ。
* $i++ より ++$i のほうが速い。