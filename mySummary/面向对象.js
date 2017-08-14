function demand(){
		this.addBtn = $('[name=demandForm] .peSave-btn');
		this.target = $('##demand');
		this.deleteBtn = '.pe-delete-btn';
		this.add();
		this.del();
	}
	demand.prototype.add=function(){
		
	}
	demand.prototype.del=function(){
		
	}
	new demand();
	//addDelete
	function addDelete(obj){
		this.addBtn = $(obj.addBtnSelector);
		this.target = $(obj.targetSelector);
		this.deleteBtn = obj.deleteBtnSelector;
	}
	addDelete.prototype = {
		addSupplyList:function(){
			var self = this;
			this.addBtn.click(function(){
				$.ajax({
					url:"<?php echo root."library/usdata.php";?>",
					type:"POST",
					dataType: "json",
					data:$('[name="supplyForm"]').serialize(),
					success:function(data){
						if(data.warn == 2){
							self.target.after('<div class="pe-info-compress clearfix"><h2 class="fl">'+data.title+'</h2><div class="fr"><a href="javascript:;" class="pe-edit-btn" data-edit-id="'+data.id+'">编辑</a><a href="javascript:;" class="pe-delete-btn" data-del-id="'+data.id+'">删除</a><a href="javascript:;" class="pe-preview-btn">预览</a></div></div>');	
						}else{
							warn(data.warn);
						}
					},error: function(){
						warn('服务器拒绝了你的请求');
					}
				})
				
				$('.pe-info-compress').first().css({'display':'none'}).fadeIn(1000);
			})
		},
		deleteSupplyList:function(){
			$(document).on('click','[data-del-id]',function(e){
				var _this =$(this);
				if(confirm("确定要删除吗？")){
					var DeleteId = _this.attr('data-del-id');
					$.getJSON('<?php echo root."library/usdata.php";?>',{DeleteId:DeleteId},function(data){
						if(data.warn == 2){
							var tar = _this.parents('.pe-info-compress');
							tar.fadeOut(function(){
								tar.remove();
							})
						}else{
							warn(data.warn);
						}
					})
				}
				
			});

		}	
	}
	var supply = new addDelete({
		addBtnSelector:'[name=supplyForm] .peSave-btn',	
		targetSelector: '#supply',
		deleteBtnSelector:'[data-del-id]'
	});
	supply.addSupplyList();
	supply.deleteSupplyList();
	var demand = new addDelete({
		addBtnSelector:'[name=demandForm] .peSave-btn',	
		targetSelector: '#demand',
		deleteBtnSelector:'.pe-delete-btn'
	});