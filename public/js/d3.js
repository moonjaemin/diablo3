$(function() {

    $('.dropdown-toggle-menu').on("click",function() {
        $('.navbar-side').slideToggle("slow");
    });

    $('.navbar-side-menu li').on("click", function() {
        location.href = $(this).attr('url');
    });

    $('.navbar-side-menu li').on("mouseover", function() {
        $(this).addClass("color-909091");
    }).on("mouseout", function() {
        $(this).removeClass("color-909091");
    });

    $('.battleTag').on("keyup", function() {

        $(".rank-btn-block").hide();
        $(".rank-text").text("");

        position = [];
        key = 0;

        var k = $(this).val();

        if(k == "") {
            scroll(0);
        } else {

            var list = $(".rank_table > tbody > tr > td:nth-child(2):contains('" + k + "')");
            $(list).each(function() {
                position.push($(this).offset().top-150);

            });

            if(position.length > 0) {


                scroll(position[key]);
                $(".rank-btn-block").show();
                $(".rank-text").text(Number(key+1)+"/"+position.length);


            } else {
                scroll(0);
            }
        }
    });

    $('.floating-down').click(function() {
        key++;
        if(key > Number(position.length-1) ) {
            key = 0;
        }

        $(".rank-text").text(Number(key+1)+"/"+position.length);
        scroll(position[key]);
    });

    $('.floating-up').click(function() {
        key--;
        if(key < 0) {
            key = Number(position.length-1);
        }

        $(".rank-text").text(Number(key+1)+"/"+position.length);
        scroll(position[key]);
    });

    $('.onlyNum').on("keyup", function() {
        $(this).val($(this).val().replace(/[^0-9]/g,""));
    });


    $('.weaponType').on("click", function() {
        var weaponType = $(this).attr('weaponType');
        $('form[name=weaponForm] input[name=weaponType]').val(weaponType);

        $('.weaponType').each(function() {
            if($(this).attr('weaponType') == weaponType) {
                $(this).removeClass('btn-default');
                $(this).addClass('btn-primary');
            } else {
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-default');
            }
        });
    });

    $('#resetCoolDown').on("click", function() {
        $('form[name=coolDownForm] select[name=head]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] select[name=shoulders]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] select[name=hands]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] select[name=waist]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] select[name=rightFinger]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] select[name=leftFinger]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] select[name=neck]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] select[name=mainHand]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] select[name=offHand]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] select[name=leoric]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] input[name=paragon]').val('');
        $('form[name=coolDownForm] select[name=gogok]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] select[name=born]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] select[name=crimson]').find("option:eq(0)").prop("selected", true);
        $('form[name=coolDownForm] select[name=skill]').find("option:eq(0)").prop("selected", true);

        coolDown();
    });

    $('#coolDownMax').on("click", function() {
        $('form[name=coolDownForm] select[name=head]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] select[name=shoulders]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] select[name=hands]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] select[name=waist]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] select[name=rightFinger]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] select[name=leftFinger]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] select[name=neck]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] select[name=mainHand]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] select[name=offHand]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] select[name=leoric]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] input[name=paragon]').val(10);
        $('form[name=coolDownForm] select[name=gogok]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] select[name=born]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] select[name=crimson]').find("option:last").prop("selected", true);
        $('form[name=coolDownForm] select[name=skill]').find("option:last").prop("selected", true);

        coolDown();
    });

    $('#resetWeapon').on("click", function() {
        $('form[name=weaponForm] select[name=weapon]').find("option:eq(0)").prop("selected", true);
        $('form[name=weaponForm] input[name=damageMin]').val('');
        $('form[name=weaponForm] input[name=damageMax]').val('');
        $('form[name=weaponForm] select[name=damage]').find("option:eq(0)").prop("selected", true);
        $('form[name=weaponForm] select[name=speed]').find("option:eq(0)").prop("selected", true);
        $('#result').html("");
    });

    $('.coolSelect').on("change", function() {
        coolDown();
    });

    $('.coolInput').on("keyup", function() {

        var paragon = $(this).val().replace(/[^0-9.]/g,"");

        if(Number(paragon) > 10) {
            $(this).val(10);
        } else {
            $(this).val(paragon);
        }

        coolDown();
    });


    $('#calcWeapon').on("click", function() {
        var weapon = $('form[name=weaponForm] select[name=weapon]');
        if(weapon.val() == '') {
            weapon.focus();
            return swal("", "무기를 선택하세요.");
        }

        var damageMin = $('form[name=weaponForm] input[name=damageMin]');
        if(damageMin.val() == '') {
            damageMin.next('.text-danger').show();
            return;
        }

        var damageMax = $('form[name=weaponForm] input[name=damageMax]');
        if(damageMax.val() == '') {
            damageMax.next('.text-danger').show();
            return;
        }

        if(parseInt(damageMin.val()) > parseInt(damageMax.val())) {
            return swal("","무기공격력 최소,최대를 정확히 입력해주세요.");
        }

        $('form[name=weaponForm]').submit();
    });

    //영웅정보
    $('.heroesInfo').on("click", function(e) {
        e.preventDefault();
        var href = $(this).find("a").attr('href').replace(/#/g,"-");;
        loading(href);
    });

    //상단메뉴
    $('.dropdown-toggle').on("click", function() {
        $('.navbar-side').toggle('blind', 500);
    });

    $('form[name=battleTagForm] input[name=battleTag]').on("keypress", function(e) {
        if(e.keyCode == 13) {
            $( ".searchBattleTag" ).trigger( "click" );
        }
    });

    $('.searchBattleTag').on("click", function(e) {

        var server = $('form[name=battleTagForm] select[name=server]');
        var battleTag = $('form[name=battleTagForm] input[name=battleTag]');

        if(battleTag.val() == '') {
            $('.text-danger').show();
        } else {
            var href = "profile/"+server.val()+"/"+battleTag.val().replace(/#/g,"-");
            loading(href);
        }
    });


    $('.battleTag, .damageMin, .damageMax').on("focusin", function(e) {
        $(this).next('.text-danger').hide();
    });

    //조회목 목록으로 확인
    $(document).on('click', '.lastBattleTags', function (e) {
        e.preventDefault();
        var href = $(this).attr('href').replace(/#/g,"-");
        loading(href);
    });

    //아이템 상세페이지 조회
    $('.heroes-gear').on("click", function(e) {

        e.preventDefault();

        $('#itemInfo').html('');
        $('#itemsArea').modal("toggle");

        var code = $(this).attr('code');
        var token = $('input[name=_token]').val();

        $.ajax({
            url:'/item',
            type : 'POST',
            data : { 'code' : code, '_token' : token },
            dataType:'html',
            success:function(res){

                $('#itemInfo').html(res);
            }
        });
    });

    //스킬,패시브
    $('.skill-data').on("click", function(e) {

        e.preventDefault();

        $('.skill-data-div').hide();
        var slug = $(this).attr('slug');

        $('#skillArea').modal("toggle");
        $("#skill-"+slug).show();
    });

    //카나이
    $('.legendary-power-item').on("click", function(e) {

        e.preventDefault();
        $('.kanai-data-div').hide();
        var key = $(this).attr('key');

        $('#kanaiArea').modal("toggle");
        $("#"+key).show();


    });

    //랭크 - 일반 하드코어
    $('.gameType').on("click", function() {
        var gameType = $(this).attr('gameType');
        $('form[name=rankForm] input[name=gameType]').val(gameType);
        $('.gameType').each(function() {
            if($(this).attr('gameType') == gameType) {
                $(this).removeClass('btn-default');
                $(this).addClass('btn-primary');
            } else {
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-default');
            }
        });
    });

    //랭크 서버
    $('.server').on("click", function() {

        var server = $(this).attr('server');
        $('form[name=rankForm] input[name=server]').val(server);

        $('.server').each(function() {

            if($(this).attr('server') == server) {
                $(this).removeClass('btn-default');
                $(this).addClass('btn-primary');
            } else {
                $(this).removeClass('btn-primary');
                $(this).addClass('btn-default');
            }
        });

    });




});

function scroll(top) {
    $('html, body').animate({
        scrollTop: top
    }, 'fast');
}

function loading(href) {
    $('#page-top').loading();
    if(navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
        setTimeout(function() {
            $('#page-top').loading('stop')
            location.href = href;
        }, 100);
    } else {
        location.href = href;
    }
}

function coolDown() {
    var w = 100;
    var r = 0;

    var head = Number($('form[name=coolDownForm] select[name=head]').val());
    if(head > 0) {
        var leoric = Number($('form[name=coolDownForm] select[name=leoric]').val());
        if(leoric > 0) {
            head = head+head/100*leoric;
        }
        w = w-w*(head/100);
    }

    var shoulders = Number($('form[name=coolDownForm] select[name=shoulders]').val());
    if(shoulders > 0) {
        w = w-w*(shoulders/100);
    }

    var hands = Number($('form[name=coolDownForm] select[name=hands]').val());
    if(hands > 0) {
        w = w-w*(hands/100);
    }

    var waist = Number($('form[name=coolDownForm] select[name=waist]').val());
    if(waist > 0) {
        w = w-w*(waist/100);
    }

    var rightFinger = Number($('form[name=coolDownForm] select[name=rightFinger]').val());
    if(rightFinger > 0) {
        w = w-w*(rightFinger/100);
    }

    var leftFinger = Number($('form[name=coolDownForm] select[name=leftFinger]').val());
    if(leftFinger > 0) {
        w = w-w*(leftFinger/100);
    }

    var neck = Number($('form[name=coolDownForm] select[name=neck]').val());
    if(neck > 0) {
        w = w-w*(neck/100);
    }

    var mainHand = Number($('form[name=coolDownForm] select[name=mainHand]').val());
    if(mainHand > 0) {
        w = w-w*(mainHand/100);
    }

    var offHand = Number($('form[name=coolDownForm] select[name=offHand]').val());
    if(offHand > 0) {
        w = w-w*(offHand/100);
    }

    var paragon = Number($('form[name=coolDownForm] input[name=paragon]').val());
    if(paragon > 0) {
        w = w-w*(paragon/100);
    }

    var gogok = Number($('form[name=coolDownForm] select[name=gogok]').val());
    if(gogok > 0) {
        w = w-w*(gogok/100);
    }

    var born = Number($('form[name=coolDownForm] select[name=born]').val());
    if(born > 0) {
        w = w-w*(born/100);
    }

    var crimson = Number($('form[name=coolDownForm] select[name=crimson]').val());
    if(crimson > 0) {
        w = w-w*(crimson/100);
    }

    var skill = Number($('form[name=coolDownForm] select[name=skill]').val());
    if(skill > 0) {
        w = w-w*(skill/100);
    }

    r = Math.round((1-w/100)*10000)/100+"%";
    $('form[name=coolDownForm] input[name=coolDown]').val(r);
}
