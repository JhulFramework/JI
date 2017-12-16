+----------------------------------------------------------------------------------------------------------------------+
| 2017Oct20
|	Context dir name must end with  _ for corect context key detection
|
|	exmaple: some\\namespace\\maincontext_\\subcontext_\\Object //context DIr= subcontext_
|	exmaple: some\\namespace\\maincontext_\\subcontext_\\deep\\er\\Object //context dir= subcontext_
|
|	exmaple: some\\namespace\\maincontext_\\Object //context dir =  maincontext_
|	exmaple: some\\namespace\\maincontext_\\deeper\\Object //context dir = maincontext_
|
|	??????????????????????????????????????????????????????????????????????????????????????
|	not tedious, but object are bound to context(which might be logical), decrease human error, might look ugly
+======================================================================================================================+

+------------------------------------------------------------------------------------------------
| 2017Oct20
|
|	alternate option is to define context key inside aevery object that needs access to context
|
|	??????????????????????????????????????????????????
|	tedious but objects can be part part on andy context(which might not nbe logical)
+=====================================================================================================

+----------------------------------------------------------------------+
| 2017Oct20
|
|	TODO
|	get contxet key form namespace
|
|	example : some\\namespace\\maincontext_\\subcontext_\\Object
|		contextKey = maincontext_subcontext
|
|		example : some\\namespace\\maincontext_\\Object
|		contextKey = maincontext
+=================================================
