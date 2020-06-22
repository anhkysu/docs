# GTM Problems

- Google Analytics RED ERROR: GTM-5P6MNP6 / Form completion "ĐẶT DỊCH VỤ NGAY !"

> Detected error
> Link iframe: https://workspace.hubservices.vn/pub/form.php?view=frame&form_id=5&widget_user_lang=en&sec=lt3rjx&r=1592832391443#%7B%22domain%22%3A%22https%3A%2F%2Famario.vn%22%2C%22from%22%3A%22https%3A%2F%2Famario.vn%2F%22%2C%22options%22%3A%7B%7D%7D
> Solution: Deleted GA found in this section

- Multiple Google Analytics Tag Found

```
Global site tag (gtag.js) (1)
UA-169925466-1
```

```
Google Analytics (2 - already error)
UA-169925466-1
```

```
Google Analytics (3)
UA-169925466-1
```

> Solution:

    - Kill the number 2 --> If ok --> Follow google guidelines for website containing iframe containing Google Analytics
    - Kill the number 3 and edit the number 2.

- Non-standard implementation

```
Google Analytics
UA-169925466-1
```

> Solution:

    - Check to see what library is causing the problem


/// You can use as many of them or as few of them as you want. The event goal will only trigger if the event matches EACH one that you’ve defined. So if you only define the category, the goal won’t care about actions, labels, or values. But if you define all four, the event must match all of them for the goal to activate.